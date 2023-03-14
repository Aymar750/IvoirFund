import { HttpClient,HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};
@Injectable({
  providedIn: 'root'
})
export class CompteService {

  constructor(private http:HttpClient) { }

//   accessCompte():Observable<any>{
//  //   return this.http.get('http://localhost:8000/profils/read.php',httpOptions)
//   }
}
