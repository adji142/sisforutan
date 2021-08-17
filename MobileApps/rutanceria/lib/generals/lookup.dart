import 'package:flutter/material.dart';
import 'dart:async';

class Lookup extends StatefulWidget {

  final String title;
  final dynamic datamodel;

  Lookup({this.title, this.datamodel});
  
  @override
  _LookupState createState() => _LookupState();
}

class _LookupState extends State<Lookup> {

  int _short = 0;
  bool _searchMode = true;
  Icon _appIcon = Icon(Icons.search, size: 32.0,);
  TextEditingController _searchText = TextEditingController();

  @override
  Widget build(BuildContext context) {
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

              IconButton(
                icon: Icon(Icons.import_export, size: 32,),
                onPressed: (){
                  _short = _short == 0 ? 1 : 0;
                  setState((){});
                },
              )
            ],
      ),
      body: Container(
              child: FutureBuilder(
                future: this.widget.datamodel.getLookup(search: this._searchText.text, short: this._short),
                builder: (context, snapshot) {
                  if (snapshot.hasError) print(snapshot.error);
                  return snapshot.hasData
                      ? _itemData(snapshot.data)
                      : new Center(
                            child: new CircularProgressIndicator(),
                        );
                },
              )
      ),
    );
  }
  
  Widget _searchWidget() {
    if(_searchMode) {
      return Text(this.widget.title);
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
                      child: ListTile(
                        //leading: Icon(Icons.check_circle_outline, color: Theme.of(context).primaryColor,),
                        title: Text(list[index]['Title'],  style: TextStyle(
                                                                          color: Theme.of(context).primaryColorDark,
                                                                          fontWeight:FontWeight.bold
                                                                          ),
                        ),
                        onTap: (){
                          Navigator.pop(context, {
                            "ID" : list[index]['ID'],
                            "Title" : list[index]['Title']
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
