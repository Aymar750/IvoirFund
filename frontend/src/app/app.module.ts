import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './Components/header/header.component';
import { FooterComponent } from './Components/footer/footer.component';
import { HomeComponent } from './Components/home/home.component';
import { MainComponent } from './Components/main/main.component';
import { CategorieComponent } from './Components/categorie/categorie.component';
import { ProjetComponent } from './Components/projet/projet.component';
import { ProjetsComponent } from './Components/pages/projets/projets.component';
import { FiltreComponent } from './Components/filtre/filtre.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    HomeComponent,
    MainComponent,
    CategorieComponent,
    ProjetComponent,
    ProjetsComponent,
    FiltreComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
