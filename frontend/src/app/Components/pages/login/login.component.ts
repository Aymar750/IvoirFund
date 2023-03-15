import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../../shared/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  loginForm!: FormGroup;
  
  constructor(
    private formBuilder: FormBuilder,
    public authService: AuthService,
    public router: Router
  ) { 
    this.loginForm = this.formBuilder.group({
      name:['',Validators.required],
      password:['',Validators.required],
    }) 
  }
  ngOnInit(): void {}
  loginUser(){
    this.authService.SignIn(this.loginForm.value)
  }

}
