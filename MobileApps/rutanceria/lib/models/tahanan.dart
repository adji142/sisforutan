import 'package:http/http.dart' as http;
import 'dart:convert';

import 'package:rutanceria/models/session.dart';

class Tahanan{
  final Session session;
  final Map param;
  Tahanan(this.session,{this.param});

  Future<Map> geTahanan() async{
    var url = 'http://${session.server}/APITahananRead';
    final response = await http.post(url, body: param);  
    return json.decode(response.body);
  }
  Future<Map> crudTahanan()async{
    var url = 'http://${session.server}/APITahananCRUD';
    final response = await http.post(url, body: param);  
    return json.decode(response.body);
  }

  Future<Map> getTahananPerlokasi()async{
    var url = 'http://${session.server}/APITahananperLocation';
    final response = await http.post(url, body: param);  
    return json.decode(response.body);
  }

  Future<Map> scanQR()async{
    var url = 'http://${session.server}/APITahananScanQR';
    final response = await http.post(url, body: param);  
    return json.decode(response.body);
  }

  Future<Map> readLog(String tanggal, String kodetahanan)async{
    Map paramLog(){
    return{
      'Tanggal' : tanggal.toString(),
      'KodeTahanan' : kodetahanan.toString()
    };
  }
    var url = 'http://${session.server}/APITahananReadLog';
    final response = await http.post(url, body: paramLog());  
    return json.decode(response.body);
  }
}