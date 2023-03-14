import { Component, OnInit } from '@angular/core';
import { Emitter } from 'src/app/emitters/authEmitter';
import { CompteService } from '../../../services/compte.service';


@Component({
  selector: 'app-compte',
  templateUrl: './compte.component.html',
  styleUrls: ['./compte.component.css']
})
export class CompteComponent implements OnInit {
  name= null;

  constructor(private compteService: CompteService) { }
  ngOnInit(): void {

    // this.compteService.accessCompte().subscribe({next: (res) => {
    //   this.name = res.name
    //   Emitter.authEmitter.emit(true)
    // },error: (error) => {
    //   Emitter.authEmitter.emit(false)
    // }})

  }

}
