import 'package:http/http.dart' as http;
import 'dart:convert';

import 'package:rutanceria/models/session.dart';

class Login{
  Session session;
  String username;
  String password;
  String role;
  Map filterQuery;
  Login(this.session,{this.username,this.password,this.role,this.filterQuery});

  Future<Map> login() async{
    var url = 'http://${session.server}/APIAUTHLogin';
    final response = await http.post(url, body: filterQuery);  
    return json.decode(response.body);
  }

  Future<Map> getDrawer() async{
    var url = 'http://${session.server}/APIAUTHgetSideBar';
    final response = await http.post(url, body: filterQuery);  
    return json.decode(response.body);
  }
}