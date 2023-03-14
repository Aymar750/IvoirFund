import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
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
import { LoginComponent } from './Components/pages/login/login.component';
import { RegisterComponent } from './Components/pages/register/register.component';
import { CompteComponent } from './Components/pages/compte/compte.component';
import { DashcompteComponent } from './Components/dashcompte/dashcompte.component';
import { NotifComponent } from './Components/pages/compte/notif/notif.component';
import { MessageComponent } from './Components/pages/compte/message/message.component';
import { ProfilComponent } from './Components/pages/compte/profil/profil.component';
import { HttpClientModule , HTTP_INTERCEPTORS } from '@angular/common/http';

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
    FiltreComponent,
    LoginComponent,
    RegisterComponent,
    CompteComponent,
    DashcompteComponent,
    NotifComponent,
    MessageComponent,
    ProfilComponent,
 
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    FormsModule,
    HttpClientModule
  ],
  providers: [
 
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
