import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { LoaderComponent } from 'app/shared/loader/loader.component';
import Announcement from 'models/announcement.interface';
import AnnouncementManagerService from 'services/announcementmanager.service';
import { Utils } from 'services/utils.service';

@Component({
  selector: 'app-property-details',
  standalone: true,
  imports: [LoaderComponent],
  templateUrl: './property-details.component.html',
  styleUrl: './property-details.component.css'
})
export class PropertyDetailsComponent implements OnInit {

  loading: boolean = false;
  announcement?: Announcement;
  successMessage?: string;
  errorMessage?: string;

  constructor(
    private router: ActivatedRoute,
    private announcementManager: AnnouncementManagerService,
    private utils: Utils
  ) { }

  ngOnInit(): void {
    const id = this.router.snapshot.paramMap.get('id');
    this.loading = true;
    this.errorMessage = undefined;
    this.announcementManager.loadOneAnnouncementById(
      Number(id) ?? 55,
      (response) => {
        this.announcement = response;
        this.loading = false;
        this.utils.reExecuteScript();
      },
      (response) => {
        this.errorMessage = response.error.detail ?? response.message ?? 'Il y\'a une erreur';
        this.loading = false;
        this.utils.reExecuteScript();
      }
    );
  }

  share() {
    navigator.share({ url: location.href });
  }

  get title() {
    return this.announcement?.title;
  }

  get description() {
    return this.announcement?.description;
  }

  get area() {
    return this.announcement?.area;
  }

  get price() {
    return this.announcement?.price;
  }

  get status() {
    return this.announcement?.status;
  }

  get contactPhone() {
    return this.announcement?.contactPhone;
  }

  get images() {
    return this.announcement?.images;
  }

  get publishedBy() {
    return this.announcement?.publishedBy;
  }

  get property() {
    return this.announcement?.property;
  }

}
