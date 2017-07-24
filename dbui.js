var express = require('express');


var bodyParser = require('body-parser');
var dateFormat = require('dateformat');
var app = express();
var handlebars = require('express-handlebars').create({defaultLayout:'mainlayout'});

app.use(express.static('views'));

app.engine('handlebars', handlebars.engine);
app.set('view engine', 'handlebars');
app.set('port', 3008);

app.use(bodyParser.urlencoded({ extended: false }))
app.use(bodyParser.json())

app.get('/cs_467_final_project-dbui',function(req,res){
  var template = {};
  template.pageTitle = "Employee Awards Admin Site";
  pool.query("SELECT * FROM users",function(err,rows,fields) {
    if(err)throw err;
    console.log(rows);
    template.rows = rows;
    template.results = JSON.stringify(rows);
    res.render('dbui.handlebars', template);
  });
});

app.post('/insert',function(req,res,next){
  var context = {};
  console.log(req.query);
  console.log(req.body);
  var date = req.body.date ? dateFormat(new Date(req.body.date),"mm/dd/yyyy") : undefined;
  console.log(date);
  pool.query("INSERT INTO users(name,email,password,sig_link,created) VALUES (?,?,?,?,?)",[req.body.userName || undefined,req.body.userEmailAddress || undefined,req.body.userPassword || undefined,req.body.userSignature || undefined, new Date() || undefined],
  function(err,result){
    if(err){
      next(err);
      return;
    }
    context.id = result.insertId;
    //console.log(context);
    res.send(context);
  });

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