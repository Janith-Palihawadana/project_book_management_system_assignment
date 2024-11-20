import { Injectable } from '@angular/core';
import {Observable} from "rxjs";
import {HttpClient, HttpParams} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class ComponentService {

  private ApiUrl = 'http://127.0.0.1:8000/api/'
  constructor(
    private http : HttpClient
  ) { }

  login(data: any): Observable<any> {
    return this.http.post(this.ApiUrl + 'auth/login', data);
  }
  registration(data:any) {
    return this.http.post(this.ApiUrl + 'auth/register', data);
  }
  getBookList(data:any,page:any ,pageSize:any){
    return this.http.post(this.ApiUrl + 'books/get_book_list?page_no=' + page + '&page_size=' + pageSize ,data);
  }

  getAuthorList(data:any,page:any ,pageSize:any){
    return this.http.post(this.ApiUrl + 'author/get_all_author_list?page_no=' + page + '&page_size=' + pageSize ,data);
  }

  getAuthorStatusChange(data:any){
    return this.http.post(this.ApiUrl + 'author/author_status_change', data);
  }

  getBookListByAuthor(data:any,page:any ,pageSize:any){
    return this.http.post(this.ApiUrl + 'books/get_book_list_by_author?page_no=' + page + '&page_size=' + pageSize ,data);
  }

  createBook(data:any){
    return this.http.post(this.ApiUrl + 'books/create_book', data);
  }

  updateBook(book_ref:any,data:any){
    return this.http.post(this.ApiUrl + 'books/update_book?book_ref='+ book_ref, data);
  }

  deleteBook(book_ref:any){
    return this.http.get(this.ApiUrl + 'books/delete-book?book_ref=' + book_ref);
  }
}
