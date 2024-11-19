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
  getBookListByAuthor(author_ref:any,page:any ,pageSize:any){
    const params = new HttpParams()
      .set('page_no', page)
      .set('page_size', pageSize)
      .set('data', author_ref);

    return this.http.get(this.ApiUrl + 'books/get_book_list_by_author', { params });
  }
}
