export interface Projects {
  project_id: number;
  title: string;
  description: string;
  creation_date: Date;
  end_date: Date;
  funding_goal: number;
  category_id: number;
  category_name: string;
  user_id: number;
  user_name: string;
  email:string;
  status_id: number;
  status_name: string;
  contribution_id:number;
  contributor_id:number;
  amount:number;
  contribution_date:Date;
  reward_id: number;
  reward_name: string;
  type_id: number;
  type_name: string;
  reward_description:string;
  minimum_amount:number;
  quantity_available: number;
  comment_id:number;
  commenter_id:number;
  commenter_content:string;
  comment_date: Date;
  image_id: number;
  filename: string;
  filetype:string;
  file_path:string;
  image_description:string;
  
}
