import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './components/login/login.component';
import { BookListComponent } from './components/book-list/book-list.component';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {HTTP_INTERCEPTORS, HttpClient, HttpClientModule} from "@angular/common/http";
import { RegistrationComponent } from './components/registration/registration.component';
import {NgbDropdownMenu, NgbDropdownModule, NgbModule, NgbPagination, NgbTooltip} from "@ng-bootstrap/ng-bootstrap";
import {NgxPaginationModule} from "ngx-pagination";
import { AuthorListComponent } from './components/author-list/author-list.component';
import { OwnBookListComponent } from './components/own-book-list/own-book-list.component';
import {NgSelectModule} from "@ng-select/ng-select";
import {AuthInterceptorService} from "./auth-interceptor.service";
import { NavigationBarComponent } from './components/navigation-bar/navigation-bar.component';
import {ToastrModule} from "ngx-toastr";
import {NgxSpinnerModule} from "ngx-spinner";

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    BookListComponent,
    RegistrationComponent,
    AuthorListComponent,
    OwnBookListComponent,
    NavigationBarComponent
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
    ToastrModule.forRoot(),
    NgxSpinnerModule
  ],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthInterceptorService,  // Register the interceptor
      multi: true  // This ensures that multiple interceptors can be used
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
