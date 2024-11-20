import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './components/login/login.component';
import { BookListComponent } from './components/book-list/book-list.component';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {HttpClient, HttpClientModule} from "@angular/common/http";
import { RegistrationComponent } from './components/registration/registration.component';
import {NgbDropdownMenu, NgbDropdownModule, NgbModule, NgbPagination, NgbTooltip} from "@ng-bootstrap/ng-bootstrap";
import {NgxPaginationModule} from "ngx-pagination";
import { AuthorListComponent } from './components/author-list/author-list.component';
import { OwnBookListComponent } from './components/own-book-list/own-book-list.component';
import {NgSelectModule} from "@ng-select/ng-select";

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    BookListComponent,
    RegistrationComponent,
    AuthorListComponent,
    OwnBookListComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    HttpClientModule,
    FormsModule,
    NgbPagination,
    NgxPaginationModule,
    NgSelectModule,
    NgbDropdownMenu,
    NgbDropdownModule,
    NgbTooltip,
  ],
  providers: [

  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
