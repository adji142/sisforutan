import 'package:http/http.dart' as http;
import 'dart:convert';

import 'package:rutanceria/models/session.dart';

class Lokasi{
  final Session session;
  final Map param;
  Lokasi(this.session,{this.param});

  Future<Map> getLokasi() async{
    var url = 'http://${session.server}/APILokasiRead';
    final response = await http.post(url, body: param);  
    return json.decode(response.body);
  }
  Future<Map> crudLokasi()async{
    var url = 'http://${session.server}/APILokasiCRUD';
    final response = await http.post(url, body: param);  
    return json.decode(response.body);
  }

  Future<List> getLookup({String search="", int short=0}) async{
    Map paramx(){
      return {
        'Kriteria' : search
      };
    }
    var url = 'http://${session.server}/APILokasiGetLookup';
    final response = await http.post(url);  
    return json.decode(response.body);
  }
}