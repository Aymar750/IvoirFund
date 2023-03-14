import { Component, OnInit } from '@angular/core';
import { Emitter } from '../../emitters/authEmitter';


@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit  {
  isLoggedIn = false ;
  ngOnInit(): void {
    Emitter.authEmitter.subscribe(res=>{
      this.isLoggedIn = res
    })
  }

  logout(){
    localStorage.removeItem('token')
    Emitter.authEmitter.emit(false)
  }

}
