/**
 * app.js - Disease Search Frontend Logic
 * Live search with debouncing, result rendering, highlighting, accessibility
 */

(function() {
  'use strict';

  // DOM Elements
  const searchInput = document.getElementById('searchInput');
  const resultsGrid = document.getElementById('results');

  // Debounce timer
  let debounceTimer = null;
  const DEBOUNCE_DELAY = 300;

  /**
   * Debounce function: delay execution until user stops typing
   */
  function debounce(fn, wait) {
    return function(...args) {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => fn.apply(this, args), wait);
    };
  }

  /**
   * Escape HTML to prevent XSS
   */
  function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  /**
   * Highlight matching query term in text (case-insensitive)
   */
  function highlightMatch(text, query) {
    if (!query || !text) return escapeHtml(text);
    
    const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
    const escaped = escapeHtml(text);
    return escaped.replace(regex, '<span class="highlight">$1</span>');
  }

  /**
   * Truncate text to max length
   */
  function truncate(text, maxLen = 150) {
    if (!text) return '';
    return text.length > maxLen ? text.substring(0, maxLen) + '...' : text;
  }

  /**
   * Fetch and render search results
   */
  async function performSearch(query) {
    try {
      const url = `search.php?q=${encodeURIComponent(query)}`;
      const response = await fetch(url);

      if (!response.ok) {
        throw new Error('Failed to fetch results');
      }

      const data = await response.json();
      renderResults(data, query);
    } catch (error) {
      console.error('Search error:', error);
      renderError('Unable to load results. Please try again.');
    }
  }

  /**
   * Render disease cards
   */
  function renderResults(diseases, query) {
    if (!Array.isArray(diseases) || diseases.length === 0) {
      renderEmpty(query);
      return;
    }

    resultsGrid.innerHTML = diseases.map(disease => {
      const name = highlightMatch(disease.name || '', query);
      const cause = truncate(disease.cause || '', 120);
      const symptoms = truncate(disease.symptoms || '', 120);
      const description = truncate(disease.description || '', 150);
      const additionalInfo = truncate(disease.additional_info || '', 100);
      const page = disease.page ? `<div class="disease-page">Page ${disease.page}</div>` : '';
      
      const tags = (disease.tags && Array.isArray(disease.tags))
        ? disease.tags.slice(0, 3).map(tag => `<span class="tag">${escapeHtml(tag)}</span>`).join('')
        : '';

      return `
        <article class="disease-card" role="article">
          <h2>${name}</h2>
          <div class="disease-meta">
            ${page}
            ${tags ? `<div class="disease-tags">${tags}</div>` : ''}
          </div>
          
          <div class="disease-field">
            <label class="disease-field-label">💊 Cause</label>
            <div class="disease-field-value">${escapeHtml(cause)}</div>
          </div>

          <div class="disease-field">
            <label class="disease-field-label">⚠️ Symptoms</label>
            <div class="disease-field-value">${escapeHtml(symptoms)}</div>
          </div>

          <div class="disease-field">
            <label class="disease-field-label">📋 Description</label>
            <div class="disease-field-value">${escapeHtml(description)}</div>
          </div>

          <div class="disease-field">
            <label class="disease-field-label">ℹ️ Additional Info</label>
            <div class="disease-field-value">${escapeHtml(additionalInfo)}</div>
          </div>
        </article>
      `;
    }).join('');
  }

  /**
   * Render empty state
   */
  function renderEmpty(query) {
    let icon = '🔍';
    let title = 'No results found';
    let text = `No diseases match "${escapeHtml(query)}"`;
    let hint = 'Try a different search term, or browse by symptom.';

    if (!query) {
      icon = '👋';
      title = 'Start searching';
      text = 'Enter a disease name, symptom, or cause to get started.';
      hint = 'Popular searches: malaria, diabetes, fever, cough';
    }

    resultsGrid.innerHTML = `
      <div class="empty-state">
        <div class="empty-state-icon">${icon}</div>
        <h2 class="empty-state-title">${title}</h2>
        <p class="empty-state-text">${text}</p>
        <p class="browse-hint">${hint}</p>
      </div>
    `;
  }

  /**
   * Render error state
   */
  function renderError(message) {
    resultsGrid.innerHTML = `
      <div class="empty-state">
        <div class="empty-state-icon">❌</div>
        <h2 class="empty-state-title">Error</h2>
        <p class="empty-state-text">${escapeHtml(message)}</p>
      </div>
    `;
  }

  /**
   * Event listener for search input
   */
  searchInput.addEventListener('input', debounce((e) => {
    const query = e.target.value.trim();
    performSearch(query);
  }, DEBOUNCE_DELAY));

  /**
   * Focus management and accessibility
   */
  searchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      searchInput.value = '';
      performSearch('');
      searchInput.focus();
    }
  });

  /**
   * Initialize: load first 10 diseases on page load
   */
  window.addEventListener('load', () => {
    performSearch('');
  });

  /**
   * Handle network errors gracefully
   */
  window.addEventListener('online', () => {
    performSearch(searchInput.value.trim());
  });

})();
