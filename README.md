# docker-phpmyadmin-tls
This image started as phpmyadmin with forcing ssl on the servers but instead now allows all configuration to be changed
via environment variable

## Usage
Every environment variable starting with `pma.` with have its values added to the configuration

Example: `pma.Servers.0.ssl=true` will enable ssl for the first(and default) server.

### Special values
Environment variable values are always strings. Thus the following string are converted to special php values

- `true` - boolean `true`
- `false` - boolean `false`
