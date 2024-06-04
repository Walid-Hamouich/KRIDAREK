import { Routes, UrlSegment } from '@angular/router';
import { NotFoundComponent } from './not-found/not-found.component';
import AuthGuard from 'services/authguard.service';

export const routes: Routes = [
    {
        path: 'dashboard',
        canActivate: [AuthGuard],
        loadChildren: () => import('./layout/dashboard-layout/dashboard-layout.module')
            .then(m => m.DashboardLayoutModule)
    },
    {
        path: '',
        loadChildren: () => import('./layout/default-layout/default-layout.module')
            .then(m => m.DefaultLayoutModule)
    },
    { path: "**", component: NotFoundComponent },
];
