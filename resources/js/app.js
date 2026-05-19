import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

import { bootKamaliUI } from './kamali/ui';
import { registerProjectGallery } from './kamali/project-gallery';
import { registerAdminProjectForm } from './kamali/admin-project-form';
import { registerAdminUserForm } from './kamali/admin-user-form';

window.Alpine = Alpine;
Alpine.plugin(collapse);
registerProjectGallery(Alpine);
registerAdminProjectForm(Alpine);
registerAdminUserForm(Alpine);
Alpine.start();

bootKamaliUI();
