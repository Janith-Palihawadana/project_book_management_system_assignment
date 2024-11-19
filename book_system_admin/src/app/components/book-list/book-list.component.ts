import { Component } from '@angular/core';
import {FormBuilder, FormGroup} from "@angular/forms";
import {ComponentService} from "../component.service";

@Component({
  selector: 'app-book-list',
  templateUrl: './book-list.component.html',
  styleUrls: ['./book-list.component.scss']
})
export class BookListComponent {
  filterForm: FormGroup;
  tableData:any;
  totalRecords: number = 0;
  page = 1;
  pageSize = 10;
  constructor(
    private formBuilder: FormBuilder,
    private componentService : ComponentService
  )
  {
    this.filterForm = this.formBuilder.group({
      keyword: [null],
    });
  }

  ngOnInit(): void {
    this._fetchData();
  }

  filterReset() {
    this.filterForm.reset();
    this._fetchData();
  }

  _fetchData() {
      this.componentService.getBookList(this.filterForm.value,this.page,this.pageSize).subscribe({
        next:(response:any)=>{
          this.tableData = response.all_books;
          this.totalRecords = response.totalRecords;
          console.log('data Successful');
        },error:(error : any) =>{
          console.log('data Unsuccessful:');
        }
      });
  }

  onPageChange = (pageNumber: number) => {
    this.page = pageNumber;
    this._fetchData();
  }
}
