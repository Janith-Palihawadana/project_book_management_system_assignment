import { Component } from '@angular/core';
import {FormBuilder, FormGroup} from "@angular/forms";
import {ComponentService} from "../component.service";
import {NgxSpinnerService} from "ngx-spinner";
import {ToastrService} from "ngx-toastr";

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
  modalImage: string = '';
  constructor(
    private formBuilder: FormBuilder,
    private componentService : ComponentService,
    private spinner: NgxSpinnerService,
    private toastr: ToastrService,
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
    this.spinner.show();
      this.componentService.getBookList(this.filterForm.value,this.page,this.pageSize).subscribe({
        next:(response:any)=>{
          this.tableData = response.all_books;
          this.totalRecords = response.totalRecords;
          this.spinner.hide();
        },error:(error : any) =>{
          this.spinner.hide();
          this.toastr.error('Something went wrong!', 'Error');
        }
      });
  }

  onPageChange = (pageNumber: number) => {
    this.page = pageNumber;
    this._fetchData();
  }

  setImageForModal(imageUrl: string): void {
    this.modalImage = imageUrl;
  }
}
