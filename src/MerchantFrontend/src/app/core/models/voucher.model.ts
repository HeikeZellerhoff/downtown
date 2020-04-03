export interface Voucher {
  id?: string;
  status: string;
  code: string;
  redeemedAt?: Date;
}

export interface VoucherListData {
  data: Voucher[];
  total: number;
}
