import { HttpClient, HttpHeaders, } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';


const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};
@Injectable({
  providedIn: 'root'
})
export class RegistrationService {

  constructor(private http:HttpClient) { }


  register(name:string,email:string,password:string):Observable<any>{
    return this.http.post('http://localhost:8000/users/register.php',{name,email,password},httpOptions);
  }


 
}