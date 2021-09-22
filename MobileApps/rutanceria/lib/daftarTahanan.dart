import 'dart:async';
import 'dart:ffi';

import 'package:flutter/material.dart';
import 'package:rutanceria/inputLokasi.dart';
import 'package:rutanceria/inputTahanan.dart';
import 'package:rutanceria/models/login.dart';
import 'package:rutanceria/models/lokasi.dart';
import 'package:rutanceria/models/session.dart';
import 'package:rutanceria/models/tahanan.dart';

class DaftarTahanan extends StatefulWidget{
  final Session session;
  DaftarTahanan(this.session);

  @override
  _DaftarTahananState createState() => _DaftarTahananState();
}

class _DaftarTahananState extends State<DaftarTahanan> {
  int _short = 0;
  bool _searchMode = true;
  Icon _appIcon = Icon(Icons.search, size: 32.0,);
  TextEditingController _searchText = TextEditingController();

  List dataDrawer;

  Future<Map> _getDrawer() async{
    Map param(){
      return{
        'id' : this.widget.session.idUser.toString()
      };
    }
    var temp = await Login(this.widget.session, filterQuery: param()).getDrawer();
    return temp;
  }
  _fetchDrawer() async{
    var temp = await _getDrawer();
    dataDrawer = temp["data"].toList();
    setState(() => {});
  }
  @override
  void initState() {
    _fetchDrawer();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    // TODO: implement build
    var width = MediaQuery.of(context).size.width / 100;
    var height = MediaQuery.of(context).size.height / 100;

    Map param(){
      return{
        'KodeLokasi'  : '',
        'Kriteria'    : _searchText.text.toString()
      };
    }
    return Scaffold(
      
      appBar: AppBar(
            title: _searchWidget(),
            actions: <Widget>[
              IconButton(
                icon: _appIcon,
                onPressed: () {
                  _searchMode = _searchMode ? false: true;
                  _searchText.text = "";
                  setState(() => _appIcon = _searchMode ? Icon(Icons.search) : Icon(Icons.close));                  
                },
              ),
            ],
      ),
      body: Container(
              child: FutureBuilder(
                future: Tahanan(widget.session, param: param()).geTahanan(),
                builder: (context, snapshot) {
                  if (snapshot.hasError) print(snapshot.error);
                  return snapshot.hasData
                      ? _itemData(snapshot.data["data"])
                      : new Center(
                            child: new CircularProgressIndicator(),
                        );
                },
              )
      ),
      floatingActionButton: FloatingActionButton(
        child: Icon(Icons.add),
        onPressed: (){
          Navigator.of(context).push(MaterialPageRoute(builder: (context) => FormInputTahanan(this.widget.session))).then((value) {
            print("Back");
            setState(() {
              
            });
          });
        }
      ),
    );
  }

  Widget _searchWidget() {
    if(_searchMode) {
      return Text(this.widget.session.appName);
    }else {
      return (
        Container(
          color: Theme.of(context).primaryColorLight,
          child: Padding(
            padding: const EdgeInsets.all(8.0),
            child: TextField(
              controller: _searchText,
              autofocus: true,
              decoration: InputDecoration.collapsed(hintText: "Cari Data"),
              textInputAction: TextInputAction.search,
              onChanged: (value) => setState((){})
            ),
          )
        )
      );
    }
  }

  Widget _itemData(List list) {
    return RefreshIndicator(
          onRefresh: ()=> _refreshData(),
          child: ListView.builder(
          itemCount: list == null ? 0 : list.length,
          itemBuilder: (context, index) {
            return Card(
                      child:  ListTile(
                        leading: list[index]["Attachment"] == '' ? CircleAvatar(child: Icon(Icons.people),) : Container(
                          width: 50,
                          decoration: BoxDecoration(
                            shape: BoxShape.circle,
                            image: DecorationImage(
                              fit: BoxFit.fill,
                              image: NetworkImage(list[index]["Attachment"])
                            )
                          ),
                        ),
                        // CircleAvatar(
                        //   child: list[index]["Attachment"] == '' ? Icon(Icons.people) : Image.network(list[index]["Attachment"]),
                        // ),
                        title: Text(list[index]['KodeTahanan'],  style: TextStyle(
                                                                          color: Theme.of(context).primaryColorDark,
                                                                          fontWeight:FontWeight.bold
                                                                    ),
                        ),
                        subtitle: Text(list[index]['NamaTahanan'].toString(), style: TextStyle(fontWeight: FontWeight.bold, color: Colors.blue),),
                        trailing: Icon(Icons.arrow_forward),
                        // trailing: Column(
                        //   mainAxisAlignment: MainAxisAlignment.center,
                        //   children: <Widget>[                
                        //     Expanded(child: Text("SHIFT ${list[index]['KodeShift']}", style: TextStyle(fontWeight: FontWeight.bold),)),
                        //     // Expanded(child: Text("${DateFormat('dd/MM/yyyy hh:mm:ss').format(DateTime.parse(list[index]['TglTransaksi']))}", style: TextStyle(color: Theme.of(context).primaryColorDark))),
                        //     Expanded(child: Text(list[index]['NamaStatus'], style: TextStyle(fontWeight: FontWeight.bold, color: Colors.red),)),
                        // ],),
                        onTap: (){
                          Navigator.of(context).push(MaterialPageRoute(builder: (context) => FormInputTahanan(this.widget.session, list: list,index: index,))).then((value) {
                            print("Back");
                            setState(() {
                              
                            });
                          });
                        },
                      ),
                    );
          },
      ),
    );
  }

  Future _refreshData() async{
      setState((){});

      Completer<Null> completer = Completer<Null>();
      Future.delayed(Duration(seconds: 1)).then( (_) {
        completer.complete();
      });
      return completer.future;
  }
  
}