window.admin_prefix = process.env.MIX_ADMIN_PREFIX
window.api_cloud_url = process.env.MIX_API_CLOUD
window.canAjax = true
if (window.screen.width > 1680 && window.screen.width <= 1920) {
    window.layerArea = ['58%', '96%']
} else if (window.screen.width > 1600 && window.screen.width <= 1680) {
    window.layerArea = ['78%', '86%']
} else if (window.screen.width > 1366 && window.screen.width <= 1600) {
    window.layerArea = ['78%', '86%']
} else if (window.screen.width <= 1366) {
    window.layerArea = ['78%', '86%']
}
