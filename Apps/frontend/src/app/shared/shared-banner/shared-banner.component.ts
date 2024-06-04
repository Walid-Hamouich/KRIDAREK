import { Component, Input } from '@angular/core';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-shared-banner',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './shared-banner.component.html',
  styleUrl: './shared-banner.component.css'
})
export class SharedBannerComponent {
  @Input()
  currentText?: string
  @Input()
  currentPage?: string
}
