import { debounce } from "lodash";

/**
 * class for filter article in ajax
 *
 * @property {HTMLElement} pagination - element html with pagination nav
 * @property {HTMLElement} Content - element html with the list of articles
 * @property {HTMLElement} sortable - Element html with the sortable btn
 * @property {HTMLFormElement} form - Element html with the form filter
 * @property {HTMLElement} count - Element html with the total item
 * @property {int} page - the number of current page
 */
export class Filter {
  constructor(element) {
    if (element == null) {
      return;
    }

    this.pagination = element.querySelector(".js-filter-pagination");
    this.content = element.querySelector(".js-filter-content");
    this.sortable = element.querySelector(".js-filter-sortable");
    this.form = element.querySelector(".js-filter-form");
    this.counters = element.querySelector(".js-filter-count");
    this.page = parseInt(
      new URLSearchParams(window.location.search).get("page") || 1
    );
    this.showMore =
      this.page === 1 && this.page < parseInt(this.content.dataset.totalPage);
    this.bindEvents();
  }

  /**
   * function for add all event listenenr on the page  */
  bindEvents() {
    const clickEventListener = (e) => {
      if (
        e.target.tagName === "A" ||
        e.target.tagName === "I" ||
        e.target.tagName === "SPAN"
      ) {
        e.preventDefault();

        let url;

        if (e.target.tagName === "I" || e.target.tagName === "SPAN") {
          url = e.target.closest("a").href;
        } else {
          url = e.target.href;
        }
        this.loadUrl(url);
      }
    };

    if (this.showMore) {
      this.pagination.innerHTML = `
      <div class="text-center">
          <button class="btn btn-primary text-center">Voir plus</button>
      </div>`;

      this.pagination
        .querySelector("button")
        .addEventListener("click", this.loadMore.bind(this));
    } else {
      this.pagination.addEventListener("click", clickEventListener);
    }

    this.sortable.addEventListener("click", clickEventListener);

    this.form.querySelectorAll('input[type="text"]').forEach((input) => {
      input.addEventListener("keyup", debounce(this.loadForm.bind(this), 300));
    });
    this.form.querySelectorAll('input[type="checkbox"]').forEach((input) => {
      input.addEventListener("change", this.loadForm.bind(this));
    });
  }

  /**
   * function for load ajax request and modify content on the page
   * @param {*} url
   * @param {bool} append - if append the content or replace }
   */
  async loadUrl(url, append = false) {
    this.showLoader();
    const params = new URLSearchParams(url.split("?")[1] || "");
    params.set("ajax", true);

    const response = await fetch(url.split("?")[0] + "?" + params.toString());

    if (response.status >= 200 && response.status < 300) {
      const data = await response.json();

      if (append) {
        this.content.innerHTML += data.content;
      }
    
      else {
        this.content.innerHTML = data.content;

      }

      if (!this.showMore) {
        this.pagination.innerHTML = data.pagination;
    } else if (this.page >= parseInt(this.content.dataset.totalPage)) {
        this.pagination.style.display = 'none';
    } else {
        this.pagination.style.display = 'block';
    }

      this.sortable.innerHTML = data.sortable;
      this.counters.innerHTML = data.count;

      this.hideLoader();

      params.delete("ajax");

      history.replaceState({}, "", url.split("?")[0] + "?" + params.toString());
    } else {
      console.error(await response.json());
    }
  }
  /**
   * function for load all information on the form and send ajax request
   */
  async loadForm() {
    this.page = 1 ; 
    const data = new FormData(this.form);
    const url = new URL(
      this.form.getAttribute("action") || window.location.href
    );
    const params = new URLSearchParams();

    data.forEach((value, key) => {
      params.append(key, value);
    });
    return this.loadUrl(url.pathname + "?" + params.toString());
  }

  async loadMore(e) {
    this.page++;

    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
    params.set("page", this.page);
    this.loadUrl(url.pathname + "?" + params.toString(), true);
  }

  showLoader() {
    this.form.classList.add("is-loading");

    const loader = this.form.querySelector(".js-loading");

    if (loader) {
      loader.setAttribute("aria-hidden", false);
      loader.style.display = "block";
    }

    return;
  }

  hideLoader() {
    this.form.classList.remove("is-loading");
    const loader = this.form.querySelector(".js-loading");
    if (loader) {
      loader.setAttribute("aria-hidden", true);
      loader.style.display = "none";
    }
    return;
  }
}
