import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { CardsComponent } from './cards/cards.component';
import { PaginationComponent } from './pagination/pagination.component';
import Announcement from 'models/announcement.interface';
import HydraView from 'models/hydraview.interface.interface';

@Component({
  selector: 'app-list',
  standalone: true,
  imports: [CardsComponent, PaginationComponent],
  templateUrl: './list.component.html',
  styleUrl: './list.component.css'
})
export class ListComponent {
  @Input()
  public announcements!: Announcement[];
  @Input()
  public annoucmentsHydraView!: HydraView;

  @Input()
  public currentPage!: number;
  @Output()
  public newPage = new EventEmitter<{ path: string, page: number }>();
}
