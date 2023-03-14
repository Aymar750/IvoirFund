import { Component,OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { FormBuilder , FormGroup, Validators } from '@angular/forms';
import { RegistrationService } from '../../../services/register.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

  registerForm!: FormGroup; 
  success = false;
  errMessage = ''

  constructor(
    private formBuilder: FormBuilder,
    private http: HttpClient,
    private registerService: RegistrationService
  ) { }
  ngOnInit(): void {
    this.registerForm = this.formBuilder.group({
      name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(6)]],
    })
  }
  register(){
    const formValue = this.registerForm.value
    this.registerService.register(formValue.name,formValue.email,formValue.password).subscribe({next: () => {
      this.success = true;
    },error: (err) => {
      console.log(err);
      
      if(err.error.code == 409){
        this.errMessage = 'le nom de cette entreprise existe deja';
      }else{
        this.errMessage = 'Quelque chose s\'est mal passé';
      }

    }})
  }

}


