var express = require('express');
const passport = require('passport')  
var Strategy = require('passport-local').Strategy;
var findByUsername = function(username, callback) {
  
    pool.query("SELECT * FROM admin WHERE email = ?", [username],function(err,rows,fields) {
    if(err)throw err;
    return callback(null, rows[0]);
  });
}

// Configure the local strategy for use by Passport.
//
// The local strategy require a `verify` function which receives the credentials
// (`username` and `password`) submitted by the user.  The function must verify
// that the password is correct and then invoke `cb` with a user object, which
// will be set at `req.user` in route handlers after authentication.
passport.use(new Strategy(
  function(username, password, cb) {
    findByUsername(username, function(err, user) {
      if (err) { return cb(err); }
      if (!user) { 
        return cb(null, false); 
      }
      if (user.password != password) { return cb(null, false); }
      return cb(null, user);
    });
}));

var bodyParser = require('body-parser');

var dateFormat = require('dateformat');
var app = express();
var handlebars = require('express-handlebars').create({defaultLayout:'mainlayout'});
app.use(require('express-session')({ secret: 'keyboard cat', resave: false, saveUninitialized: false }));
app.use(require('cookie-parser')());
app.use(express.static('views'));

app.engine('handlebars', handlebars.engine);
app.set('view engine', 'handlebars');
app.set('port', 3004);

app.use(bodyParser.urlencoded({ extended: false }))
app.use(bodyParser.json())
app.use(passport.initialize());
app.use(passport.session());
var findByEmail = function(email, callback) {
    pool.query("SELECT * FROM admin WHERE email = ?", [email],function(err,rows,fields) {
    if(err)throw err;
    return callback(null, rows[0]);
  });
}; 

passport.serializeUser(function(user, callback) {
  console.log("User is",user);
  callback(null, user.email);
});

passport.deserializeUser(function(email, cb) {
  findByEmail(email, function (err, user) {
    if (err) { return cb(err); }
    cb(null, user);
  });
});

app.get('/login', function(req,res){
  var template = {};
  template.pageTitle = "Login Page";
  res.render('login_page', template);

});

app.post('/login', function(req, res, next) {
  passport.authenticate('local', function(err, user, info) {
    if (err) { return next(err); }
    if (! user) {
      res.status(401);
      var template = {};
      template.error = "User or password is incorrect";
      template.pageTitle = "Login Page";
      res.render('login_page', template);
    } else {
      console.log("user!", user);
      req.logIn(user, function(err) {
        if (err) { return next(err); }
        return res.redirect('/home');
      })
    }
  })(req, res, next);
});

function authenticationMiddleware () {  
  return function (req, res, next) {
    if (req.isAuthenticated()) {
      return next()
    }
    res.redirect('/login')
  }
}

app.get('/home', authenticationMiddleware(), function(req,res){
  var template = {};
  template.pageTitle = "Employee Awards Admin Site";
  pool.query("SELECT * FROM users",function(err,rows,fields) {
    if(err)throw err;
    
    template.rows = rows;
    template.results = JSON.stringify(rows);
    res.render('home', template);
  });
});

app.get('/list_users', authenticationMiddleware(), function(req,res){
  var template = {};
  template.pageTitle = "Employee Awards Admin Site";
  pool.query("SELECT * FROM users",function(err,rows,fields) {
    if(err)throw err;
    
    template.rows = rows;
    template.results = JSON.stringify(rows);
    res.render('list_users.handlebars', template);
  });
});

app.get('/list_users_reporting', authenticationMiddleware(), function(req,res){
  var template = {};
  template.pageTitle = "Employee Awards Admin Site";
  pool.query("SELECT * FROM users",function(err,rows,fields) {
    if(err)throw err;
    
    template.rows = rows;
    template.showReporting = true;
    template.results = JSON.stringify(rows);
    res.render('list_users_reporting.handlebars', template);
  });
});

app.get('/create_new_user', authenticationMiddleware(), function(req,res){
  var template = {};
  template.pageTitle = "Employee Awards Admin Site";
    res.render('create_new_user.handlebars', template);
});

app.get('/create_new_admin_user', authenticationMiddleware(), function(req,res){
  var template = {};
  template.pageTitle = "Employee Awards Admin Site";
  pool.query("SELECT * FROM users",function(err,rows,fields) {
    if(err)throw err;
    
    template.rows = rows;
    template.results = JSON.stringify(rows);
    res.render('create_new_admin_user.handlebars', template);
  });
});


app.get('/logout',
  function(req, res){
    req.logout();
    res.redirect('/login');
});

//renders the page that lists the admin users
app.get('/list_admin_users', authenticationMiddleware(), function(req,res){
  var template = {};
  template.pageTitle = "All Admin Users";
  pool.query("SELECT * FROM admin",function(err,rows,fields) {
    if(err)throw err;
    //console.log(rows);
    template.rows = rows;
    template.results = JSON.stringify(rows);
    res.render('list_admin_users.handlebars', template);
  });
});


app.get('/list_admin_users_reporting', authenticationMiddleware(), function(req,res){
  var template = {};
  template.pageTitle = "All Admin Users";
  pool.query("SELECT * FROM admin",function(err,rows,fields) {
    if(err)throw err;
    //console.log(rows);
    template.rows = rows;
    template.showReporting = true;
    template.results = JSON.stringify(rows);
    res.render('list_admin_users_reporting', template);
  });
});

var getAwardTypes = function(usersByAwardTypes) {
  var awardTypes = [];
  for (var i = 0; i < usersByAwardTypes.length; i++) {
    var userByAward = usersByAwardTypes[i];
    if (! awardTypes.includes(userByAward.award_name)) {
      awardTypes.push(userByAward.award_name);
    }
  }
  return awardTypes;
}

var getUsersWithCountPerAward = function(rows, awardTypes) {
  var usersMapPerAward = {};
  for (var i =0; i<rows.length; i++) {
    var userPerAward = rows[i];
    if (! usersMapPerAward[userPerAward.owner]) {
      usersMapPerAward[userPerAward.owner] = awardTypes.map(function(award) {
        var count = 0
        if (award == userPerAward.award_name) {
          count = userPerAward.num_awards
        }

        return {award: award, count: count}
      });
    } else {
      usersMapPerAward[userPerAward.owner] = usersMapPerAward[userPerAward.owner].map(function(awardToCountMap) {
        var count = awardToCountMap.count
        if (awardToCountMap.award == userPerAward.award_name) {
          count = userPerAward.num_awards
        }

        return {award: awardToCountMap.award, count: count}
      })
    }
  }

  return usersMapPerAward;
}

//renders the page that lists all awards created 
app.get('/list_awards', authenticationMiddleware(), function(req,res){
  var template = {};
  template.pageTitle = "Employee Recognition Awards";
  pool.query("select owner, count(*) as num_awards, full_name as award_name from awards a join award_types at on at.type_id = a.awards_type group by owner, full_name order by full_name desc;",function(err,rows,fields) {
    if(err)throw err;
    //console.log(rows);
    var awardTypes = getAwardTypes(rows);
    var usersWithEachAwardType = getUsersWithCountPerAward(rows, awardTypes);
    
    template.rows = rows;
    template.showReporting = true;
    template.results = JSON.stringify(usersWithEachAwardType);
    template.awardTypes = JSON.stringify(awardTypes);
    res.render('list_awards.handlebars', template);
  });
});

//renders the page that lists all awards created 
app.get('/award_types_granted', authenticationMiddleware(), function(req,res){
  var template = {};
  template.pageTitle = "Employee Recognition Awards";
  pool.query("select count(*) as num_awards, full_name as award_name from awards a join award_types at on at.type_id = a.awards_type group by full_name order by full_name desc;",function(err,rows,fields) {
    if(err)throw err;
    //console.log(rows);
    
    template.rows = rows;
    template.showReporting = true;
    template.results = JSON.stringify(rows);
    res.render('award_types_granted.handlebars', template);
  });
});


//renders the page that gives the user access to run reports 
app.get('/reporting', authenticationMiddleware(), function(req,res){
  var template = {};
  template.pageTitle = "Awards Granted By Type";
  pool.query("SELECT * FROM admin",function(err,rows,fields) {
    if(err)throw err;
    // console.log(rows);
    template.rows = rows;
    template.results = JSON.stringify(rows);
    template.showReporting = true;
    //console.log(template.results);
    //res.render('reporting.handlebars', template);
    res.render('reporting.handlebars', template);
  });
});

app.post('/insert_user', authenticationMiddleware(), function(req,res,next){
  var context = {};
  //console.log(req.body);
  var date = req.body.date ? dateFormat(new Date(req.body.date),"mm/dd/yyyy") : undefined;
  //console.log(date);
  pool.query("INSERT INTO users(email,password,user_name,user_last_name,security_word,registration_time) VALUES (?,?,?,?,?,?)",[req.body.userEmailAddress || undefined,req.body.userPassword || undefined,req.body.userFirstName || undefined,req.body.userLastName || undefined,req.body.userSecurityWord || undefined, new Date() || undefined],
  function(err,result){
    if(err){
      next(err);
      return;
    }
    context.email = result.email;
    //console.log(context);
    res.redirect('/list_users');
  });

});

//updating regular users 
app.post('/update/:email',authenticationMiddleware(), function(req,res,next){
  var context = {};
  pool.query("SELECT * FROM users WHERE email=?", [req.params.email], function(err, result){
    if(err){
      next(err);
      return;
    }
    if(result.length == 1){
      var currentValue = result[0];
      //these values currentValue.example need to correspond with SQL column names
      pool.query("UPDATE users SET user_name=?, user_last_name=?, email=?, password=?, security_word = ? WHERE email=? ",
        [req.body.user_name || currentValue.user_name, req.body.user_last_name || currentValue.user_last_name, req.body.email || currentValue.email, 
        req.body.password || currentValue.password, req.body.security_word || currentValue.security_word, req.params.email],
        function(err, result){
        if(err){
          next(err);
          return;
        }
        context.results = "Updated " + result.changedRows + " rows.";
        res.redirect('/list_users');
      });
    }
  });
});

app.delete('/delete/:email', authenticationMiddleware(), function (req, res) {
    pool.query('DELETE FROM users WHERE email=?',[req.params.email],function(err,result){
    if(err){
      next(err);
      return;
    }
  console.log('DELETED email'+ req.params.email);
  res.send('DELETED email'+ req.params.email);
  });
});


app.post('/insert_admin', authenticationMiddleware(),function(req,res,next){
  var context = {};
  //console.log(req.query);
  //console.log(req.body);
  var date = req.body.date ? dateFormat(new Date(req.body.date),"mm/dd/yyyy") : undefined;
  //console.log(date);
  pool.query("INSERT INTO admin(name,email,password,created) VALUES (?,?,?,?)",[req.body.adminUserName || undefined,req.body.adminUserEmailAddress || undefined,req.body.adminUserPassword || undefined, new Date() || undefined],
  function(err,result){
    if(err){
      next(err);
      return;
    }
    context.email = result.email;
    //console.log(context);
    res.redirect('/list_admin_users');
  });

});

//updating admin table after the website user has hit edit 
app.post('/update_admin/:email',authenticationMiddleware(),function(req,res,next){
  var context = {};
    pool.query("SELECT * FROM admin WHERE email=?", [req.params.email], function(err, result){
    if(err){
      next(err);
      return;
    }
    if(result.length == 1){
      var currentValue = result[0];
      //these values currentValue.example need to correspond with SQL column names
      pool.query("UPDATE admin SET name=?, email=?, password=? WHERE email=? ",
        [req.body.name || currentValue.name, req.body.email || currentValue.email, req.body.password || currentValue.password, req.params.email],
        function(err, result){
        if(err){
          next(err);
          return;
        }
        context.results = "Updated " + result.changedRows + " rows.";
        res.redirect('/list_admin_users');
      });
    }
  });
});

//renders the edit page for editing non administrative users 
app.get('/edit/users/:email', authenticationMiddleware(), function(req,res,next){
  var context = {};
  pool.query("SELECT * FROM users WHERE email=?", [req.params.email], function(err, result){
    if(err){
      next(err);
      return;
    }
    //console.log(result);
    if(result.length == 1){
      context.row = result[0];
      //console.log(context);
    } else {
      context.hasError = true
    }
    res.render('edit_users.handlebars',context);
  })
});

//renders the edit page for editing the admin users 
app.get('/edit/admin/:email',authenticationMiddleware(), function(req,res,next){
  var context = {};
  pool.query("SELECT name, email, password, created FROM admin WHERE email=?", [req.params.email], function(err, result){
    if(err){
      next(err);
      return;
    }
    if(result.length == 1){
      context.row = result[0];
    } else {
      context.hasError = true
    }
    res.render('edit_admin_users.handlebars',context);
  })
});

app.delete('/delete_admin/:email', authenticationMiddleware(), function (req, res) {
    pool.query('DELETE FROM admin WHERE email=?',[req.params.email],function(err,result){
    if(err){
      next(err);
      return;
    }
  console.log('DELETED email'+ req.params.email);
  res.send('DELETED email'+ req.params.email);
  });
});

app.get('/', function(req,res){
  res.redirect('/login');
});



var dB = require('mysql');
var pool = dB.createPool({
  host : 'localhost',
  user : 'lauralaz',
  //password :'Babybear09!',
  database : 'cs_467',
});

app.use(function(req,res){
  res.status(404);
  res.render('404errors');
});

app.use(function(err, req, res, next){
  console.error(err.stack);
  res.type('plain/text');
  res.status(500);
  res.render('500errors');
});

app.listen(app.get('port'), function(){
  console.log('Express started on http://localhost:' + app.get('port') + '; press Ctrl-C to terminate.');
});