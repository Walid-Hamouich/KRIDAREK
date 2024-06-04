import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { ANNOUNCEMENT_PER_PAGE, API_ENDPOINT } from 'app/config/constants';
import HydraView from 'models/hydraview.interface.interface';

@Component({
  selector: 'app-pagination',
  standalone: true,
  imports: [],
  templateUrl: './pagination.component.html',
  styleUrl: './pagination.component.css'
})
export class PaginationComponent implements OnInit {

  @Input()
  public announcementsHydraView!: HydraView;
  @Input()
  public currentPage!: number;

  private userId!: string | null;
  private pagesArray: number[] = [];

  @Output()
  public newPage = new EventEmitter<{ path: string, page: number }>();

  ngOnInit(): void {
    if (this.announcementsHydraView["@id"]) {
      let url = new URL(`${API_ENDPOINT}/${this.announcementsHydraView["@id"]}`);
      this.userId = url.searchParams.get("publishedBy.id");
    }
    this.pagesArray = this.constructPagesArray();
  }

  private constructPagesArray(): number[] {
    const pagesArray = [];
    const {
      ["hydra:totalItems"]: totalItems,
    } = this.announcementsHydraView;
    console.log(totalItems);
    for (let i = Math.max(1, this.currentPage - 5 + 2); i <=
      Math.ceil(totalItems / ANNOUNCEMENT_PER_PAGE); i++) {
      pagesArray.push(i);
      console.log(i);
    }
    return pagesArray;
  }

  get getPagesArray(): number[] {
    return this.pagesArray;
  }

  get getCurrentPage(): number {
    return this.currentPage;
  }

  public changePage(event: Event, page: number) {
    event.preventDefault();
    this.newPage.emit({ path: `/api/announcements?publishedBy.id=${this.userId}&page=${page}`, page });
    this.currentPage = page;
  }
}
