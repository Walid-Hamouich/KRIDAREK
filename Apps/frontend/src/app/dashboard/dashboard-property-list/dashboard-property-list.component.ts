import { Component, OnInit } from '@angular/core';
import { TitleComponent } from './title/title.component';
import { SearchAreaComponent } from './search-area/search-area.component';
import { ListingTableComponent } from './listing-table/listing-table.component';
import { HttpClient } from '@angular/common/http';
import CurrentUserService from 'services/currentuser.service';
import Announcement from 'models/announcement.interface';
import { LoaderComponent } from 'app/shared/loader/loader.component';
import HydraView from 'models/hydraview.interface.interface';
import AnnouncementManagerService from 'services/announcementmanager.service';
import { ANNOUNCEMENT_PER_PAGE } from 'app/config/constants';

@Component({
  selector: 'app-dashboard-property-list',
  standalone: true,
  imports: [TitleComponent, SearchAreaComponent, ListingTableComponent, LoaderComponent],
  templateUrl: './dashboard-property-list.component.html',
  styleUrl: './dashboard-property-list.component.css'
})
export class DashboardPropertyListComponent implements OnInit {

  private currentPage: number = 1;
  private loading: boolean = false;
  private errorMessage?: string;
  private successMessage?: string;
  private announcements: Announcement[] = [];
  private hydraView!: HydraView;

  constructor(
    private httpClient: HttpClient,
    private currentUser: CurrentUserService,
    private announcementManager: AnnouncementManagerService
  ) {

  }

  async ngOnInit() {
    await this.loadAnnouncements(`/api/announcements/?publishedBy.id=${this.currentUser.currentUser()!.id}`);
  }

  loadAnnouncements(path: string): Promise<any> {
    return new Promise((resolved, rejected) => {
      this.loading = true;
      this.errorMessage = undefined;
      this.httpClient.get(
        `http://localhost:9000${path}`
      ).subscribe({
        next: (response: any) => {
          this.hydraView = response["hydra:view"];
          this.hydraView["hydra:totalItems"] = response["hydra:totalItems"];
          this.announcements = response["hydra:member"];
          this.loading = false;
          resolved(response);
        }, error: (error) => {
          this.loading = false;
          this.errorMessage = error.error.detail;
          rejected(error);
        }
      })

    });
  }

  changePage({ path, page }: { path: string, page: number }) {
    this.loadAnnouncements(path);
    this.currentPage = page;
  }

  deleteAnnouncement(id: number) {
    this.errorMessage = undefined;
    this.successMessage = undefined;
    this.loading = true;
    this.announcementManager.deleteAnnouncement(id,
      async () => {
        await this.loadAnnouncements(
          `/api/announcements/?publishedBy.id=${this.currentUser.currentUser()!.id}&page=${this.currentPage}`
        );
        if (this.currentPage > Math.ceil((this.hydraView["hydra:totalItems"])
          / ANNOUNCEMENT_PER_PAGE)) {
          this.currentPage--;
        }
        this.successMessage = "La proprieté a été supprimé";
      }, (error) => {
        this.loading = false;
        this.errorMessage = error?.error?.detail;
      }
    );
  }

  get getAnnouncements(): Announcement[] {
    return this.announcements;
  }

  get getLoading(): boolean {
    return this.loading;
  }

  get getCurrentPage(): number {
    return this.currentPage;
  }

  get getHydraView(): HydraView {
    return this.hydraView;
  }

  get getErrorMessage() {
    return this.errorMessage;
  }

  get getSuccessMessage() {
    return this.successMessage;
  }
}
