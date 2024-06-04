import { Component, Input, OnInit, Output } from '@angular/core';
import { ShowItemsFilterComponent } from './show-items-filter/show-items-filter.component';
import { SharedBannerComponent } from 'app/shared/shared-banner/shared-banner.component';
import { ListComponent } from './list/list.component';
import { FilterAreaComponent } from './filter-area/filter-area.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { EventEmitter } from 'stream';
import Announcement from 'models/announcement.interface';
import { HttpClient, HttpContext } from '@angular/common/http';
import { BYPASS_LOGIN } from 'interceptors/auth.interceptor';
import { Utils } from 'services/utils.service';
import { LoaderComponent } from 'app/shared/loader/loader.component';
import HydraView from 'models/hydraview.interface.interface';
import { ANNOUNCEMENTS_ENDPOINT, API_ENDPOINT } from 'app/config/constants';

@Component({
  selector: 'app-property-list',
  standalone: true,
  imports: [SharedBannerComponent, ListComponent, ShowItemsFilterComponent, FilterAreaComponent,
    SidebarComponent, LoaderComponent],
  templateUrl: './property-list.component.html',
  styleUrl: './property-list.component.css'
})
export class PropertyListComponent implements OnInit {

  private currentPage: number = 1;
  private announcements: Announcement[] = [];
  private loading: boolean = false;
  private hydraView: HydraView = {
    "@id": undefined,
    "@type": undefined,
    "hydra:totalItems": 0,
    "hydra:first": undefined,
    "hydra:previous": undefined,
    "hydra:next": undefined,
    "hydra:last": undefined
  };

  private currentFilter: {
    filterName: string,
    value: string
  }[] = [];

  private errorMessage?: string;

  constructor(
    private httpClient: HttpClient,
    private utils: Utils
  ) {

  }



  loadAnnouncements(path: string): void {
    this.loading = true;
    this.errorMessage = undefined;
    this.announcements = [];
    this.httpClient.get(`http://localhost:9000${path}`,
      { context: new HttpContext().set(BYPASS_LOGIN, true) }
    ).subscribe({
      next: (response: any) => {
        this.hydraView = response["hydra:view"] ?? {};
        this.hydraView['hydra:totalItems'] = response["hydra:totalItems"];
        const data = response["hydra:member"];
        for (let item of data) {
          this.announcements.push({
            id: item["id"],
            slug: item["slug"],
            title: item["title"],
            description: item["description"],
            price: item["price"],
            contactPhone: item["contactPhone"],
            area: item["area"],
            images: item["images"],
            status: item["status"],
            createdAt: item["createdAt"],
            property: item["property"]
          });
        }
        this.loading = false;
        this.utils.reExecuteScript();
      },
      error: (response: any) => {
        this.loading = false;
        this.errorMessage = response.error.detail ?? "Un erreur a été rencontré";
      }
    });
  }

  ngOnInit(): void {
    this.loadAnnouncements('/api/announcements');
  }

  get getAnnouncements() {
    return this.announcements;
  }

  get getHydraView() {
    return this.hydraView;
  }

  get getLoading() {
    return this.loading;
  }

  get getCurrentPage() {
    return this.currentPage;
  }

  get getErrorMessage() {
    return this.errorMessage;
  }

  public changePage({ path, page }: { path: string, page: number }) {
    this.loadAnnouncements(`${path}&${this.buildFilter()}`);
    this.currentPage = page;
  }

  buildFilter() {
    let filterString = "";
    for (let filter of this.currentFilter) {
      filterString += `${filter.filterName}=${filter.value}&`;
    }
    return filterString;
  }

  filter(city: string) {
    this.currentPage = 1;
    // if (city === "") {
    //   const filterString = this.buildFilter();
    //   this.loadAnnouncements(`/api/announcements?${filterString}`)
    // }
    let cityFilter = this.currentFilter.find(({ filterName, value }) => filterName === `property.city.label`);
    if (!cityFilter) {
      cityFilter = {
        filterName: `property.city.label`,
        value: city
      };
      this.currentFilter.push(cityFilter);
    }
    else {
      cityFilter.value = city;
    }
    const filterString = this.buildFilter();
    this.loadAnnouncements(`/api/announcements?${filterString}`)
  }
}
