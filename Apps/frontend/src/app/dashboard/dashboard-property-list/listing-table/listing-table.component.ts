import { Component, EventEmitter, Input, Output } from '@angular/core';
import Announcement from 'models/announcement.interface';
import { RowComponent } from './row/row.component';
import { PaginationComponent } from './pagination/pagination.component';
import HydraView from 'models/hydraview.interface.interface';

@Component({
  selector: 'app-listing-table',
  standalone: true,
  imports: [RowComponent, PaginationComponent],
  templateUrl: './listing-table.component.html',
  styleUrl: './listing-table.component.css'
})
export class ListingTableComponent {
  @Input()
  public announcements: Announcement[] = [];

  @Input()
  public announcementsHydraView!: HydraView;

  @Input()
  public currentPage: number = 1;

  @Output()
  public newPage = new EventEmitter<{ path: string, page: number }>();

  @Output()
  public delete = new EventEmitter<number>();
}
