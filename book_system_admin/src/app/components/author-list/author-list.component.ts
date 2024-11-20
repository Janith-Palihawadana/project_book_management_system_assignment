import { Component } from '@angular/core';
import {FormBuilder, FormGroup} from "@angular/forms";
import {ComponentService} from "../component.service";

@Component({
  selector: 'app-author-list',
  templateUrl: './author-list.component.html',
  styleUrls: ['./author-list.component.scss']
})
export class AuthorListComponent {
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
      is_active: [true]
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
    this.componentService.getAuthorList(this.filterForm.value,this.page,this.pageSize).subscribe({
      next:(response:any)=>{
        this.tableData = response.all_author;
        console.log(this.tableData);
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

  statusChange(row: any) {
    const data = {
      author_ref: row.user_ref,
      is_active: !row.is_active,
    }

    this.componentService.getAuthorStatusChange(data).subscribe({
      next:(response:any)=>{
       this._fetchData();
       console.log('data Successful');
      },error:(error : any) =>{
        console.log('data Unsuccessful:');
      }
    });
  }
}
