import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:procttor/models/api_response.dart';
import 'package:procttor/models/user.dart';
import 'package:procttor/screens/home.dart';
import 'package:procttor/screens/signupscreen.dart';
import 'package:procttor/services/user_service.dart';
import 'package:shared_preferences/shared_preferences.dart';

class LoginPage extends StatefulWidget {
  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final _formfield=GlobalKey<FormState>();
  final emailController=TextEditingController();
  final passController=TextEditingController();
  bool passToggle=true;
  bool loading = false;

  void _loginUser() async{
    ApiResponse response = await login(emailController.text, passController.text);
    if (response.error==null){
      _saveAndRedirectToHome(response.data as User);
    }
    else{
      setState(() {
        loading=false;
      });
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('${response.error}')));
      print('${response.error}');
    }
  }

  void _saveAndRedirectToHome(User user) async{
    SharedPreferences pref = await SharedPreferences.getInstance();
    await pref.setString('token', user.token ?? '');
    await pref.setInt('userId', user.id ?? 0);
    Navigator.of(context).pushAndRemoveUntil(MaterialPageRoute(builder: (context)=>Home()), (route) => false);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold( backgroundColor: Colors.white,
        body: SingleChildScrollView( child: Center(child: Form(key: _formfield, child: Column(
          children: <Widget>[
            SizedBox(height: 50,),
            Image.asset('assets/logo.png', width: 150, height: 150,),
            const Padding(
              padding: EdgeInsets.only(left: 10, top: 0, right: 10, bottom: 10),
              child: Text(
                "Procttor",
                style: TextStyle(
                    fontSize: 27,
                    //fontFamily: ,
                    fontWeight: FontWeight.bold,
                    color: Colors.black),
              ),
            ),
            const SizedBox(
              height: 15,
            ),
            Padding(
              padding: EdgeInsets.only(left: 20, top: 0, right: 20, bottom: 0),
              child: TextFormField(
                keyboardType: TextInputType.emailAddress,
                controller: emailController,
                decoration: InputDecoration(
                    border: OutlineInputBorder(),
                    //borderRadius: BorderRadius.all(Radius.circular(10))),
                    labelText: 'Email',
                    isDense: true,
                    hintText: 'Enter your email',
                    prefixIcon: Icon(Icons.email)
                ),
                validator: (value){
                  bool emailValid=RegExp(r"^[a-zA-Z0-9.a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9]+\.[a-zA-Z]+").hasMatch(value!);
                  if(value.isEmpty){
                    return "Enter Email";
                  }
                  else if(!emailValid){
                    return "Enter Valid Email";
                  }
                },
              ),
            ),
            const SizedBox(
              height: 15,
            ),
            Padding(
              padding: EdgeInsets.only(left: 20, top: 0, right: 20, bottom: 0),
              child: TextFormField(
                keyboardType: TextInputType.visiblePassword,
                controller: passController,
                decoration: InputDecoration(
                    border: OutlineInputBorder(borderSide: const BorderSide(color: Colors.tealAccent)),
                    labelText: 'Password',
                    hintText: 'Enter your password',
                    prefixIcon: Icon(Icons.lock),
                    suffixIcon: InkWell(
                      onTap: (){
                        setState(() {
                          passToggle=!passToggle;
                        });
                      },
                      child: Icon(passToggle? Icons.visibility:Icons.visibility_off),
                    )),
                validator: (value){
                  if(value!.isEmpty){
                    return "Enter Password";
                  }
                  else if(passController.text.length<8){
                    return "Password must be >= 8 characters";
                  }
                },
                obscureText: passToggle,
              ),
            ),
            const SizedBox(
              height: 15,
            ),
            loading? Center(child: CircularProgressIndicator()):
            SizedBox(
              width: MediaQuery.of(context).size.width,
              child: Padding(
                  padding: const EdgeInsets.only(
                      left: 20, top: 0, right: 20, bottom: 0),
                  child: ElevatedButton(
                    onPressed: () {
                      if (_formfield.currentState!.validate()){
                        print('login pressed');
                        setState(() {
                          loading=true;
                          _loginUser();
                          //emailController.clear();
                          //passController.clear();
                        });
                      }
                    },
                    style: ElevatedButton.styleFrom(backgroundColor: Colors.tealAccent[700]),
                    child: const Text("Log in", style: TextStyle(color: Colors.white),),
                  )),
            ),
            Align(
                alignment: Alignment.topLeft,
                child:
                Padding(
                    padding: EdgeInsets.only(left: 20, top:5),
                    child: GestureDetector(
                      child: Text("Forget your password?",
                        style: TextStyle(fontSize: 13, color: Colors.blueGrey),
                      ),
                      onTap: (){print("Hello from password");},))),
            SizedBox(height: 30,),
            Text.rich(TextSpan(children: [
              TextSpan(
                  text: "Don't have account? ", style: TextStyle(fontSize: 13)),
              TextSpan(
                  text: "Sign Up",
                  style: TextStyle(fontSize: 13, color: Colors.blue),
                  recognizer: TapGestureRecognizer()
                    ..onTap = () {
                    Navigator.of(context).pushAndRemoveUntil(MaterialPageRoute(builder: (context)=>SignUpPage()), (route) => false);
                    })
            ]))
          ],
        ),
        ))));
  }
}