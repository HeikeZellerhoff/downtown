import { Component, OnInit } from '@angular/core';
import { MerchantApiService } from '../../core/services/merchant-api.service';
import { Voucher, VoucherListData } from '../../core/models/voucher.model';

@Component({
  selector: 'portal-merchant-vouchers',
  templateUrl: './merchant-vouchers.component.html'
})
export class MerchantVouchersComponent implements OnInit {

  vouchers: Voucher[] = [];
  loading: boolean;
  total: number;
  limit = 10;
  offset: number;
  currentPage = 1;
  fromVoucher: number;
  tillVoucher: number;

  constructor(
    private merchantApiService: MerchantApiService
  ) {
  }

  ngOnInit(): void {
    this.offset = 0;
    this.refresh();
  }

  refresh(): void {
    this.loading = true;
    this.merchantApiService.getVouchers()
      .subscribe(
        (voucherList: VoucherListData) => {
          this.vouchers = voucherList.data;
          this.total = voucherList.total;
          //this.pageChange();
          this.loading = false;
        }
      )
  }

  pageChange(): void {
    this.offset = (this.currentPage - 1) * 10;

    if (this.currentPage === 1) {
      this.fromVoucher = this.fromVoucher = 1;
    } else {
      this.fromVoucher = (this.currentPage -1) * this.limit;
    }

    if (this.fromVoucher + this.limit <= this.total) {
      this.tillVoucher = this.fromVoucher + this.limit;
      if (this.fromVoucher === 1) {
        this.tillVoucher -= 1;
      }
    } else {
      this.tillVoucher = this.total;
    }
  }
}
