import 'dart:async';

import 'package:flutter/material.dart';
import 'package:rutanceria/models/session.dart';
import 'package:rutanceria/models/tahanan.dart';

class DaftarCheck extends StatefulWidget{
  final Session session;
  final String namaLokasi;
  final String kodelokasi;
  DaftarCheck(this.session,this.namaLokasi, this.kodelokasi);

  @override
  _DaftarCheckState createState() => _DaftarCheckState();
}
class _DaftarCheckState extends State<DaftarCheck> {
  int _short = 0;
  bool _searchMode = true;
  Icon _appIcon = Icon(Icons.search, size: 32.0,);
  TextEditingController _searchText = TextEditingController();

  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    var width = MediaQuery.of(context).size.width / 100;
    var height = MediaQuery.of(context).size.height / 100;

    Map param(){
      return {
        'KodeLokasi' : this.widget.kodelokasi.toString()
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
                future: Tahanan(widget.session, param: param()).getTahananPerlokasi(),
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
      bottomNavigationBar: Container(
        padding: EdgeInsets.all(10),
        width: width * 100,
        height: height * 10,
        child: Row(
          mainAxisAlignment: MainAxisAlignment.start,
          children: [
            SizedBox(
              width: width * 45,
              height: height * 10,
              child: RaisedButton(
                onPressed: (){

                },
                color: Colors.green,
                textColor: Colors.white,
                child: Text("Check In"),
              ),
            ),
            SizedBox(width: width*5,),
            SizedBox(
              width: width * 45,
              height: height * 10,
              child: RaisedButton(
                onPressed: (){

                },
                color: Colors.red,
                textColor: Colors.white,
                child: Text("Check Out"),
              ),
            )
          ],
        ),
      )
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
    var width = MediaQuery.of(context).size.width / 100;
    var height = MediaQuery.of(context).size.height / 100;
    return RefreshIndicator(
          onRefresh: ()=> _refreshData(),
          child: ListView.builder(
          itemCount: list == null ? 0 : list.length,
          itemBuilder: (context, index) {
            return Card(
                      child: ListTile(
                        leading: Icon(Icons.widgets, color: Theme.of(context).primaryColor,),
                        title: Text(list[index]['NamaTahanan'],  style: TextStyle(
                                                                          color: Theme.of(context).primaryColorDark,
                                                                          fontWeight:FontWeight.bold
                                                                    ),
                        ),
                        subtitle: Text(list[index]["KodeTahanan"].toString() , style: TextStyle(fontWeight: FontWeight.bold, color: Colors.blue),),
                        trailing: Container(
                          width: width * 30 ,
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.end,
                            children: [
                              Container(
                                width: width * 10,
                                child: CircleAvatar(
                                  backgroundColor: Colors.green,
                                  foregroundColor: Colors.white,
                                  child: Text(list[index]["CheckIn"]),
                                ),
                              ),
                              Container(width: width * 3,),
                              Container(
                                width: width * 10,
                                child: CircleAvatar(
                                  backgroundColor: Colors.red,
                                  foregroundColor: Colors.white,
                                  child: Text(list[index]["CheckOut"]),
                                ),
                              )
                            ],
                          ),
                        ),
                        onTap: (){
                          Navigator.of(context).push(MaterialPageRoute(builder: (context) => DaftarCheck(this.widget.session,list[index]['NamaLokasi'],list[index]['KodeLokasi'])));
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