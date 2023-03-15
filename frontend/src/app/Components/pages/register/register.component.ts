import { Component,OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { FormBuilder , FormGroup, Validators } from '@angular/forms';
import { AuthService } from 'src/app/shared/auth.service';
import { Router } from '@angular/router';


@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

  registerForm!: FormGroup; 
  constructor(
    public formBuilder: FormBuilder,
    public authService : AuthService,
    private http: HttpClient,
    public router: Router
  ) { 
    this.registerForm = this.formBuilder.group({
      name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(6)]],
    })
  }
  ngOnInit(): void {}

  registerUser(){
    this.authService.SignUp(this.registerForm.value).subscribe((res) => {
      if (res){
        // this.formBuilder.reset();
        this.router.navigate(['/login']);
      }
    })
  }

}


