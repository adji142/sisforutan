import 'package:flutter/material.dart';
import 'package:rutanceria/generals/dialogs.dart';
import 'package:rutanceria/home.dart';
import 'package:rutanceria/models/session.dart';
import 'package:rutanceria/models/login.dart';
// import 'package:rutanceria/pages/home.dart';

class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  TextEditingController _kodeUser = TextEditingController();
  TextEditingController _password = TextEditingController();

  double _ratio;
  Session session = Session();       

  @override
  void initState() {
    
    session.kodeUser= "";
    session.namaUser= "";
    session.server= "192.168.1.66/rutan";
    session.appName = "Rutan Ceria";
    _ratio = 2;
    super.initState();
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(      
      bottomNavigationBar: new SizedBox(
        height: 60,
        child: Container(
          child: Center(child: Text("Copyright © AIS System, 2021", style: TextStyle(color: Colors.black, fontSize: 14),))
        ),
      ),

      body: ListView(
        children: <Widget>[
          
          Container( 
            color: Theme.of(context).primaryColor,
            width: double.infinity,
            height: MediaQuery.of(context).size.height / _ratio,
            child: Center( 
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: <Widget>[

                  Padding(
                    padding: const EdgeInsets.only(bottom: 20),
                    child: Container(
                      width: 80,
                      height: 80,
                      child: CircleAvatar(
                        backgroundImage: ExactAssetImage('images/jail.png'),
                        minRadius: 90,
                        maxRadius: 150
                      ),
                    )
                  ),    

                  Text("SISTEM INFORMASI RUTAN", style: TextStyle(color: Colors.white, fontSize: 32, fontWeight: FontWeight.bold),),
                  Text("RUTAN CERIA", style: TextStyle(color: Colors.white, fontSize: 16),),

              ],)
            ),
          ),

          Padding(
            padding: const EdgeInsets.fromLTRB(20, 10, 20, 0),
            child: TextField(
              controller: _kodeUser,
              decoration: InputDecoration(
                  icon: Icon(Icons.person,
                      size: 32,
                      color: Theme.of(context).primaryColorDark),
                  labelText: "User",
                  labelStyle: TextStyle(
                      color: Theme.of(context).primaryColorDark)
              ),

              onTap: () {
                _ratio = 3.5;
              },
              onSubmitted: (_) {
                _ratio = 2;
              },

            ),
          ),

          Padding(
            padding: const EdgeInsets.fromLTRB(20, 0, 20, 0),
            child: TextField(
              obscureText: true,  
              controller: _password,
              decoration: InputDecoration(
                  icon: Icon(Icons.lock,
                      size: 32,
                      color: Theme.of(context).primaryColorDark),
                  labelText: "Password",
                  labelStyle: TextStyle(
                      color: Theme.of(context).primaryColorDark)
              ),
              onTap: () {
                _ratio = 3;
              },
              onSubmitted: (_) {
                _ratio = 2;
              },
            ),
          ),

          Padding(
            padding: const EdgeInsets.fromLTRB(20, 15, 20, 0),
            child: RaisedButton(
              color: Theme.of(context).primaryColor,
              shape: StadiumBorder(),
              child: Text(
                "Masuk",
                style: TextStyle(
                    color: Colors.white),
              ),
              onPressed: () async{
                _kodeUser.text = _kodeUser.text.trim();
                _password.text = _password.text.trim();
                
                Map param(){
                  return{
                    'username' : _kodeUser.text,
                    'pass'     : _password.text
                  };
                }

                var user = await Login(session, filterQuery: param()).login().then((val) async{
                  if (val["success"].toString() == "true") {
                    session.kodeUser = val["username"].toString();
                    session.namaUser = val["nama"].toString();
                    session.role = int.parse(val["role"].toString());
                    session.idUser = int.parse(val["unique_id"].toString());
                    Navigator.pushReplacement(context, MaterialPageRoute(builder: (context) => Home(session)));
                  }
                  else{
                    await messageBox(context: context, title: "Peringatan", message: val["message"].toString());
                  }
                });
                // if(user == null) {
                //    await messageBox(context: context, title: "Peringatan", message: "Koneksi Ke Server Tidak Berhasil !, Cek Koneksi Jaringan..");  
                // }else if(user.length==0) {
                //    await messageBox(context: context, title: "Peringatan", message: "User dan Password Tidak Sesuai, atau Tidak Terdaftar di Sistem !"); 
                // }else{
                //   session.kodeUser= user[0]["KodeUser"];
                //   session.namaUser= user[0]["NamaUser"];
                //   session.role = 
                //   // Navigator.pushReplacement(context, MaterialPageRoute(builder: (context) => Home(session: session)));
                // }
              },     
            ),
          ),

        ],
      ));
  }
}

