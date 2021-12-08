require('./bootstrap');

import Alpine from 'alpinejs';
import flatpickr from "flatpickr";
import * as FilePond from "filepond";
import { createPopper } from "@popperjs/core";

window.flatpickr = flatpickr;
window.FilePond = FilePond;
window.createPopper = createPopper;
window.Alpine = Alpine;

Alpine.start();
