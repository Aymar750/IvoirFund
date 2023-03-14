import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient, HttpHeaders, } from '@angular/common/http';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json'})
};



@Injectable({
  providedIn: 'root'
})
export class LoginService {
  

  constructor(private http:HttpClient) { }
  // getData() {
  //   const headers = new HttpHeaders().set('Access-Control-Allow-Origin', '*');
  //   return this.http.get('http://localhost:8000/users/login.php', { headers });
  //         }
  login(name:string,password:string):Observable<any>{
    console.log(name,password);
    
    return this.http.post('http://localhost:8000/users/login.php',{name,password},httpOptions)
  }

}
