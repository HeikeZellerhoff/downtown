import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { ClarityModule, ClrFormsModule } from '@clr/angular';
import { MerchantAccountModule } from '../merchant-account/merchant-account.module';
import { MerchantVouchersComponent } from './merchant-vouchers.component';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    ClrFormsModule,
    ClarityModule,
    MerchantAccountModule
  ],
  declarations: [
    MerchantVouchersComponent
  ],
  exports: [
    MerchantVouchersComponent
  ],
})
export class MerchantVouchersModule {
}
