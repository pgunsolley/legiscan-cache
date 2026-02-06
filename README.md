# Legiscan Cache

## Development Installation

1. Install [DDEV](https://ddev.com/get-started/)
2. Clone repository and `cd` into it 
3. Start DDEV with `ddev start`
4. Install dependencies `ddev exec composer install`
5. Run migrations `ddev cake migrations migrate`
6. Add Legiscan API key to config/app_local.php at `Integrations.legiscan.key`
