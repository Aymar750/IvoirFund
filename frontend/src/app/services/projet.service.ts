import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { throwError } from 'rxjs/internal/observable/throwError';
import { catchError } from 'rxjs/operators';
import { Projects } from '../Interfaces/projects';

@Injectable({
  providedIn: 'root'
})
export class ProjetService {
  headers = new HttpHeaders({ 'Content-Type': 'application/json' });
  constructor(private http :HttpClient) { }

  getAllProjects(){
    return this.http.get<any>('http://localhost:8000/projets/read.php');
  }
  createproject(projet:Projects){
    return this.http.post('http://localhost:8000/projets/create.php', projet).pipe(catchError(this.handleError));
  }
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
