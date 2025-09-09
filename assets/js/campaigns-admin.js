/**
 * Campaigns & Projects Admin JavaScript
 * 
 * Handles interactive elements for the admin dashboard
 */

(function($) {
    'use strict';
    
    // Initialize when document is ready
    $(document).ready(function() {
        initDashboard();
    });
    
    /**
     * Initialize dashboard functionality
     */
    function initDashboard() {
        // Initialize charts if we're on the dashboard page
        if ($('.campaigns-dashboard').length) {
            initCharts();
        }
    }
    
    /**
     * Initialize dashboard charts
     */
    function initCharts() {
        // Platform chart (pie chart)
        if ($('#platformChart').length && typeof portfolioCampaigns !== 'undefined') {
            const platformCtx = document.getElementById('platformChart').getContext('2d');
            
            const platformData = {
                labels: portfolioCampaigns.platforms.labels,
                datasets: [{
                    data: portfolioCampaigns.platforms.counts,
                    backgroundColor: [
                        '#0077b5', // LinkedIn
                        '#e4405f', // Instagram
                        '#1da1f2', // Twitter
                        '#6366f1', // Project
                        '#10b981', // Campaign
                        '#94a3b8'  // Other
                    ],
                    borderWidth: 1
                }]
            };
            
            new Chart(platformCtx, {
                type: 'doughnut',
                data: platformData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Time chart (line chart)
        if ($('#timeChart').length && typeof portfolioCampaigns !== 'undefined') {
            const timeCtx = document.getElementById('timeChart').getContext('2d');
            
            const timeData = {
                labels: portfolioCampaigns.dates.labels,
                datasets: [{
                    label: 'Campaigns',
                    data: portfolioCampaigns.dates.counts,
                    borderColor: '#3858e9',
                    backgroundColor: 'rgba(56, 88, 233, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            };
            
            new Chart(timeCtx, {
                type: 'line',
                data: timeData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    }
    
})(jQuery);
