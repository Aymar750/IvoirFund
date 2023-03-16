import { AuthService } from './../../../shared/auth.service';
import { Component, OnInit } from '@angular/core';



@Component({
  selector: 'app-compte',
  templateUrl: './compte.component.html',
  styleUrls: ['./compte.component.css']
})
export class CompteComponent implements OnInit {

  constructor(private authService: AuthService) { }
  logout() {
    this.authService.doLogout();
  }

  ngOnInit(): void {


    // this.compteService.accessCompte().subscribe({next: (res) => {
    //   this.name = res.name
    //   Emitter.authEmitter.emit(true)
    // },error: (error) => {
    //   Emitter.authEmitter.emit(false)
    // }})

  }

}
