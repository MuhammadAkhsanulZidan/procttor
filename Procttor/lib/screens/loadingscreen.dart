import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:procttor/constant.dart';
import 'package:procttor/models/api_response.dart';
import 'package:procttor/screens/loginscreen.dart';
import 'package:procttor/screens/home.dart';
import 'package:procttor/services/user_service.dart';

class Loading extends StatefulWidget {
  @override
  _LoadingState createState() => _LoadingState();
}

class _LoadingState extends State<Loading> {
  void _loadUserInfo() async {
    String token = await getToken();
    if(token == ''){
      Navigator.of(context as BuildContext).pushAndRemoveUntil(MaterialPageRoute(builder: (context)=>LoginPage()), (route) => false);
    }
    else{
      ApiResponse response = await getUserDetails();
      if(response.error==null){
        Navigator.of(context as BuildContext).pushAndRemoveUntil(MaterialPageRoute(builder: (context)=>Home()), (route) => false);
      }
      else if(response.error==unauthorized){
        Navigator.of(context as BuildContext).pushAndRemoveUntil(MaterialPageRoute(builder: (context)=>LoginPage()), (route) => false);
      }
      else{
        ScaffoldMessenger.of(context as BuildContext).showSnackBar(SnackBar(content: Text('${response.error}')));
      }
    }
}

@override
  void initState() {
    _loadUserInfo();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      color: Colors.white,
      height: MediaQuery.of(context).size.height,
      child: Center(child: CircularProgressIndicator(),
    ));
  }
}
