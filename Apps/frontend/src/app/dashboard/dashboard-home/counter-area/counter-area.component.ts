import { Component, OnInit } from '@angular/core';
import { LoaderComponent } from 'app/shared/loader/loader.component';
import Status from 'models/status.enum';
import AnnouncementManagerService from 'services/announcementmanager.service';
import CurrentUserService from 'services/currentuser.service';
import { Utils } from 'services/utils.service';

@Component({
  selector: 'app-counter-area',
  standalone: true,
  imports: [LoaderComponent],
  templateUrl: './counter-area.component.html',
  styleUrl: './counter-area.component.css'
})
export class CounterAreaComponent implements OnInit {

  public allAnnouncementsCount: string = "-1";
  public processingAnnouncementsCount: string = "-1";
  public publishedAnnouncementsCount: string = "-1";
  public deletedAnnouncementsCount: string = "-1";
  public loading: boolean = false;

  constructor(
    private utils: Utils,
    private announcementManager: AnnouncementManagerService,
    private currentUserService: CurrentUserService
  ) { }

  ngOnInit(): void {
    this.loading = true;

    this.announcementManager.loadAnnouncementsCount(
      this.currentUserService.currentUser()?.id ?? 0,
      (response) => {
        this.allAnnouncementsCount = response.count;
        this.finishLoading();
      },
      (error) => {
        this.allAnnouncementsCount = "-2";
        this.finishLoading();
      }
    );
    this.announcementManager.loadAnnouncementsCountByStatus(
      this.currentUserService.currentUser()?.id ?? 0,
      Status.PROCESSING,
      (response) => {
        this.processingAnnouncementsCount = response.count;
        this.finishLoading();
      },
      (error) => {
        this.processingAnnouncementsCount = "-2";
        this.finishLoading();
      }
    );

    this.announcementManager.loadAnnouncementsCountByStatus(
      this.currentUserService.currentUser()?.id ?? 0,
      Status.PUBLISHED,
      (response) => {
        this.publishedAnnouncementsCount = response.count;
        this.finishLoading();
      },
      (error) => {
        this.publishedAnnouncementsCount = "-2";
        this.finishLoading();
      }
    );

    this.announcementManager.loadAnnouncementsCountByStatus(
      this.currentUserService.currentUser()?.id ?? 0,
      Status.DELETED,
      (response) => {
        this.deletedAnnouncementsCount = response.count;
        this.finishLoading();
      },
      (error) => {
        this.deletedAnnouncementsCount = "-2";
        this.finishLoading();
      }
    );
  }

  private checkIfAllDone(): boolean {
    return this.allAnnouncementsCount !== "-1" && this.processingAnnouncementsCount !== "-1"
      && this.publishedAnnouncementsCount !== "-1" && this.deletedAnnouncementsCount !== "-1";
  }

  private finishLoading() {
    if (this.checkIfAllDone()) {
      this.loading = false;
      this.utils.counterUp();
    }
  }

}
