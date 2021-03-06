export interface Product {
  id?: string;
  name: string;
  description: string;
  productType: string;
  active: boolean;
  media: any[];
  price?: number;
  tax?: number;
}

export interface ProductListData {
  data: Product[];
  total: number;
}
