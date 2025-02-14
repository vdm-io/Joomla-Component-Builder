/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/* JS Document */
class MastodonFeed {
  constructor(containerId, refreshButtonId) {
    this.container = document.getElementById(containerId);
    this.refreshButton = document.getElementById(refreshButtonId);

    // Get settings from data attributes
    this.mastodonInstance = this.container.dataset.instance;
    this.accountId = this.container.dataset.accountId;
    this.postCount = parseInt(this.container.dataset.postCount) || 5;

    this.cacheKey = "mastodon-feed-cache";
    this.cacheExpiration = 24 * 60 * 60 * 1000; // 24 hours in milliseconds

    // Initialize the feed
    this.initFeed();

    // Attach event listener for the refresh button
    this.refreshButton.addEventListener("click", () => this.clearCacheAndReload());
  }

  async initFeed() {
    const cachedData = this.getCachedData();

    if (cachedData) {
      this.renderFeed(cachedData);
    } else {
      await this.loadFeed();
    }
  }

  getCachedData() {
    const cache = localStorage.getItem(this.cacheKey);
    if (!cache) return null;

    const parsedCache = JSON.parse(cache);
    const now = new Date().getTime();

    if (now - parsedCache.timestamp > this.cacheExpiration) {
      // Cache is expired
      this.clearCache();
      return null;
    }

    return parsedCache.data;
  }

  setCachedData(data) {
    const cache = {
      timestamp: new Date().getTime(),
      data: data,
    };
    localStorage.setItem(this.cacheKey, JSON.stringify(cache));
  }

  clearCache() {
    localStorage.removeItem(this.cacheKey);
  }

  async loadFeed() {
    try {
      const response = await fetch(`${this.mastodonInstance}/api/v1/accounts/${this.accountId}/statuses?limit=${this.postCount}`);

      if (!response.ok) {
        throw new Error(`Failed to fetch Mastodon feed: ${response.statusText}`);
      }

      const posts = await response.json();
      this.setCachedData(posts); // Cache the data
      this.renderFeed(posts);
    } catch (error) {
      console.error("Error loading Mastodon feed:", error);
      this.container.innerHTML = `<div class="alert alert-danger">Error loading feed. Please try again later.</div>`;
    }
  }

  renderFeed(posts) {
    // Clear existing content
    this.container.innerHTML = "";

    posts.forEach(post => {
      if (!post.content) return; // Ignore posts with no content

      // Create post element
      const listItem = document.createElement("div");
      listItem.className = "well well-small";

      const postContent = document.createElement("div");

      const user = post.account;
      const avatar = user.avatar_static;
      const displayName = user.display_name || user.username;

      // User header
      const header = document.createElement("div");
      header.className = "media";

      const avatarLink = document.createElement("a");
      avatarLink.href = user.url;
      avatarLink.className = "pull-left";

      const avatarImg = document.createElement("img");
      avatarImg.src = avatar;
      avatarImg.alt = displayName;
      avatarImg.className = "img-circle";
      avatarImg.style.width = "40px";

      avatarLink.appendChild(avatarImg);

      const userInfo = document.createElement("div");
      userInfo.className = "media-body";

      const nameLink = document.createElement("a");
      nameLink.href = user.url;
      nameLink.className = "muted";
      nameLink.textContent = displayName;

      const username = document.createElement("span");
      username.className = "small muted";
      username.textContent = ` (@${user.username})`;

      const userHeader = document.createElement("h5");
      userHeader.appendChild(nameLink);
      userHeader.appendChild(username);

      userInfo.appendChild(userHeader);

      header.appendChild(avatarLink);
      header.appendChild(userInfo);

      // Post content
      const content = document.createElement("p");
      content.innerHTML = post.content;

      // Interactions
      const interactions = document.createElement("div");
      interactions.className = "btn-group";

      // View Post link
      const viewPost = document.createElement("a");
      viewPost.href = post.url;
      viewPost.className = "btn btn-small btn-primary";
      viewPost.innerHTML = `View Post&nbsp;&nbsp;
        &nbsp;&nbsp;<i class="icon-comments"></i> ${post.replies_count}&nbsp;
        &nbsp;&nbsp;<i class="icon-thumbs-up"></i> ${post.favourites_count}&nbsp;
        <i class="icon-loop"></i> ${post.reblogs_count}`;
      interactions.appendChild(viewPost);

      // Join Me link
      const joinLink = document.createElement("a");
      joinLink.href = "https://joomla.social/invite/gzAvC48K";
      joinLink.className = "btn btn-small btn-success";
      joinLink.textContent = "Join Me";
      interactions.appendChild(joinLink);

      // Assemble post
      postContent.appendChild(header);
      postContent.appendChild(content);
      postContent.appendChild(interactions);

      listItem.appendChild(postContent);
      this.container.appendChild(listItem);
      this.container.classList.remove('loading');
    });
  }

  clearCacheAndReload() {
    // Add spinning effect to the refresh button
    this.refreshButton.classList.add('spinning');

    // Show placeholder content
    this.container.classList.add('loading');
    this.container.innerHTML = this.generatePlaceholder();

    // Clear cache and reload feed
    this.clearCache();

    // Wait for 3 seconds
    setTimeout(() => {
      // Enlarge and fade out the refresh button
      this.refreshButton.classList.add('enlarge-and-disappear');

      // After the animation, reset the button and content
      setTimeout(() => {
        this.refreshButton.classList.remove('spinning', 'enlarge-and-disappear');
        this.refreshButton.style.display = '';

        // Remove placeholder and restore actual content
        this.loadFeed();
      }, 1000); // Animation time for fade-out
    }, 3000); // Spinning duration
  }

  generatePlaceholder() {
    let placeholders = '';
    for (let i = 0; i < this.postCount; i++) {
      placeholders += `
          <div class="placeholder">
            <div class="placeholder-circle"></div>
            <div class="placeholder-line"></div>
            <div class="placeholder-line"></div>
            <div class="placeholder-line"></div>
            <div class="placeholder-line"></div>
          </div>
        `;
    }
    return placeholders;
  }
}

class IconWaveAnimator {
  constructor(containerId, detailsId) {
    this.details = document.getElementById(detailsId);
    this.container = document.getElementById(containerId);
    this.icons = this.container.querySelectorAll("i");
    this.links = this.container.querySelectorAll("a");
    this.init();
  }

  init() {
    // set the icon hover events
    this.setupHoverEvents();

    // Random chance to do nothing (1 out of 10)
    if (Math.random() < 0.1) return;

    // Randomize the initial delay before starting
    const initialDelay = Math.random() * 2000 + 2000; // 2–4 seconds
    setTimeout(() => {
      this.randomBehavior();
    }, initialDelay);

    // Occasionally trigger a second wave after 10 seconds
    if (Math.random() > 0.5) {
      setTimeout(() => {
        this.mexicanWave(false); // Reverse wave
      }, 10000);
    }
  }

  mexicanWave(forward = true) {
    let delay = 0;
    const iconsArray = Array.from(this.icons);

    (forward ? iconsArray : iconsArray.reverse()).forEach((icon) => {
      setTimeout(() => {
        icon.style.transition = "transform 0.3s ease-in-out";
        icon.style.transform = "scale(1.3)";
        setTimeout(() => {
          icon.style.transform = "scale(1)";
        }, 300);
      }, delay);
      delay += 150; // Stagger the effect for the wave
    });
  }

  randomBehavior() {
    const waveDirection = Math.random() > 0.5 ? "forward" : "backward";
    const waveCount = Math.floor(Math.random() * 10) + 1; // 1 to 5 waves
    const interval = Math.random() * 2000 + 3000; // 3 to 5 seconds

    let executedCount = 0;
    const intervalId = setInterval(() => {
      if (executedCount >= waveCount) {
        clearInterval(intervalId);
        return;
      }
      this.mexicanWave(waveDirection === "forward");
      executedCount++;
    }, interval);
  }

  setupHoverEvents() {
    this.links.forEach((link) => {
      link.addEventListener("mouseenter", () => this.showDetails(link));
      link.addEventListener("mouseleave", () => this.clearDetails());
    });
  }

  showDetails(link) {
    const description = link.dataset.description;
    if (this.details && description) {
      this.details.textContent = description;
    }
  }

  clearDetails() {
    if (this.details) {
      this.details.textContent = "";
    }
  }
}