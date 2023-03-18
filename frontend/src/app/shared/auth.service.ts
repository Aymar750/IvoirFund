import { Injectable } from '@angular/core';
import { User } from './user';
import { Observable, throwError } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import {
  HttpClient,
  HttpHeaders,
  HttpErrorResponse,
} from '@angular/common/http';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})

export class AuthService {
  endpoint:string = 'http://localhost:8000/users';
  headers = new HttpHeaders({ 'Content-Type': 'application/json' });
  currentUser = new User();

  constructor(private http: HttpClient, public router: Router) { }

  //register new user
  SignUp(user: User) {
    let api = `${this.endpoint}/register.php`;
    return this.http.post(api, user).pipe(catchError(this.handleError));
  }

  //login user

  SignIn(user: User) {
    return this.http.post<any>(`${this.endpoint}/login.php`, user).subscribe((res:any) => {
      localStorage.setItem('token', res.token);
      localStorage.setItem('user', JSON.stringify(res.data));
      this.getUserProfile(res.data.user_id).subscribe((res:any) => {
        this.currentUser = res;
        console.log(this.currentUser);
        this.router.navigate(['compte/tableauBord']);
      });  
      // this.getUserProfile(res.data.id).subscribe((res:any) => {
      //   this.currentUser = res;
      //   console.log(res);
        
      //   this.router.navigate(['/compte/mon-profil'+ res.msg._id]);
      // });
    });
  }

  getToken(){
    return localStorage.getItem('token');
  }

  get isLoggedIn(): boolean {
    let authToken = localStorage.getItem('token');
    return authToken!= null? true : false;
  }
  doLogout(){
    let removeToken = localStorage.removeItem('token');
    if(removeToken== null){
      this.router.navigate(['/login']);
    }
  }
  //Get profil User
  getUserProfile(id: any): Observable<any> {
    let api = `${this.endpoint}/readbyid.php/${id}`;
    return this.http.get<any>(api, {headers: this.headers}).pipe(map((res:any) => {
      return res || {};
    }),
    catchError(this.handleError)
    );
  }

  //error handler
  handleError(error: HttpErrorResponse) {
    let msg = '';
    if (error.error instanceof ErrorEvent) {
      // client-side error
      msg = error.error.message;
    } else {
      // server-side error
      msg = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    return throwError(msg);
  }
}
