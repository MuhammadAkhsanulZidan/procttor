import 'package:procttor/models/api_response.dart';
import 'package:procttor/models/user.dart';
import 'package:procttor/screens/home.dart';
import 'package:procttor/screens/loginscreen.dart';
import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:procttor/services/user_service.dart';
import 'package:shared_preferences/shared_preferences.dart';

class SignUpPage extends StatefulWidget {
  @override
  State<SignUpPage> createState() => _SignUpPageState();
}

class _SignUpPageState extends State<SignUpPage> {
  final _formfield = GlobalKey<FormState>();
  final emailController = TextEditingController();
  final passController = TextEditingController();
  final passConfirmController = TextEditingController();
  final nameController = TextEditingController();

  void _signupUser() async{
    ApiResponse response = await signup(nameController.text, emailController.text, passController.text);
    if(response.error==null){
      _saveAndRedirectToHome(response.data as User);
    }
    else{
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('${response.error}')));
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
        body: SingleChildScrollView(
            child: Form(key: _formfield,
              child: Column(
                children: <Widget>[
                  SizedBox(
                    height: 50,
                  ),
                  Image.asset('assets/logo.png', width: 100, height: 100,),
                  const SizedBox(
                    height: 20,
                  ),
                  const Padding(
                    padding: EdgeInsets.only(left: 10, top: 10, right: 10, bottom: 10),
                    child: Text(
                      "Manage Your Project With Us",
                      style: TextStyle(
                          fontSize: 18,
                          //fontFamily: ,
                          fontWeight: FontWeight.bold,
                          color: Colors.black),
                    ),
                  ),
                  const SizedBox(
                    height: 15,
                  ),
                  Padding(
                    padding: EdgeInsets.only(left: 20, top: 0, right: 20, bottom: 10),
                    child: TextFormField(
                      keyboardType: TextInputType.name,
                      decoration: const InputDecoration(
                          border: OutlineInputBorder(),
                          //borderRadius: BorderRadius.all(Radius.circular(10))),
                          labelText: 'Username',
                          isDense: true,
                          hintText: 'Enter your username'),
                      style: TextStyle(fontSize: 13),
                      controller: nameController,
                      validator: (value) {
                        if (value!.isEmpty) {
                          return "Enter your name";
                        }
                      },
                    ),
                  ),
                  Padding(
                    padding: EdgeInsets.only(left: 20, top: 0, right: 20, bottom: 10),
                    child: TextFormField(
                      keyboardType: TextInputType.emailAddress,
                      decoration: const InputDecoration(
                          border: OutlineInputBorder(),
                          //borderRadius: BorderRadius.all(Radius.circular(10))),
                          labelText: 'Email',
                          isDense: true,
                          hintText: 'Enter your Email'),
                      style: TextStyle(fontSize: 13),
                      validator: (value) {
                        bool emailValid = RegExp(
                            r"^[a-zA-Z0-9.a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9]+\.[a-zA-Z]+")
                            .hasMatch(value!);
                        if (value.isEmpty) {
                          return "Enter Email";
                        } else if (!emailValid) {
                          return "Enter Valid Email";
                        }
                      },
                    ),
                  ),
                  Padding(
                    padding: EdgeInsets.only(left: 20, top: 0, right: 20, bottom: 10),
                    child: TextFormField(
                      keyboardType: TextInputType.visiblePassword,
                      controller: passController,
                      decoration: const InputDecoration(
                          border: OutlineInputBorder(
                              borderSide: BorderSide(color: Colors.cyan)),
                          labelText: 'Password',
                          isDense: true,
                          hintText: 'Enter your password'),
                      obscureText: true,
                      style: TextStyle(fontSize: 13),
                      validator: (value) {
                        if (value!.isEmpty) {
                          return "Enter Password";
                        } else if (passController.text.length < 8) {
                          return "Password must be => 8 characters";
                        }
                      },
                    ),
                  ),
                  Padding(
                    padding: EdgeInsets.only(left: 20, top: 0, right: 20, bottom: 10),
                    child: TextFormField(
                      keyboardType: TextInputType.visiblePassword,
                      controller: passConfirmController,
                      decoration: const InputDecoration(
                          border: OutlineInputBorder(
                              borderSide: BorderSide(color: Colors.cyan)),
                          labelText: 'Confirm Password',
                          isDense: true,
                          hintText: 'Confirm your password'),
                      obscureText: true,
                      style: TextStyle(fontSize: 13),
                      validator: (value) {
                        if (value!.isEmpty) {
                          return "Enter Password Confirmation";
                        } else if (passConfirmController.text != passController.text) {
                          return "Password don't match";
                        }
                      },
                    ),
                  ),
                  SizedBox(
                    width: MediaQuery.of(context).size.width,
                    child: Padding(
                        padding: const EdgeInsets.only(
                            left: 20, top: 0, right: 20, bottom: 0),
                        child: ElevatedButton(
                          onPressed: () {
                            if (_formfield.currentState!.validate()){
                              print("success");
                              nameController.clear();
                              emailController.clear();
                              passController.clear();
                              passConfirmController.clear();
                            }
                          },
                          style: ElevatedButton.styleFrom(backgroundColor: Colors.tealAccent[700]),
                          child: const Text(
                            "Sign Up",
                            style: TextStyle(color: Colors.white),
                          ),
                        )),
                  ),
                  SizedBox(
                    height: 20,
                  ),
                  Text.rich(TextSpan(children: [
                    TextSpan(
                        text: "Already have an account? ", style: TextStyle(fontSize: 13)),
                    TextSpan(
                        text: "Sign In",
                        style: TextStyle(fontSize: 13, color: Colors.blue),
                        recognizer: TapGestureRecognizer()
                          ..onTap = () {
                            Navigator.push(context, MaterialPageRoute(builder: (context) => LoginPage()));
                          })
                  ]))
                ],
              ),
            )));
  }
}
