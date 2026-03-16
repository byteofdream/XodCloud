# XodCloud (Dark Glass Edition)

A full-stack music sharing demo inspired by modern SoundCloud UX patterns, rebuilt with a dark glassmorphism aesthetic.

## Requirements
- PHP 8.x
- SQLite 3
- A local web server (Apache/Nginx) or PHP built-in server

## Setup
1. Create the SQLite database and sample data:
   - Create `storage/app.sqlite`
   - Execute the SQL in `database.sqlite.sql`
2. Update the DB path in `config/config.php` if needed.
3. Ensure `/uploads` is writable by PHP.
4. Start a server from the project root:
   - `php -S localhost:8000`
5. Open:
   - `http://localhost:8000/index.php`

## Demo accounts
- `echo@example.com` / `password123`
- `night@example.com` / `password123`

## Features
- User registration and login
- Profile pages with avatar, bio, follow/unfollow
- Stream + Library pages
- Upload MP3 tracks
- Track pages with waveform player
- Like + repost + share + comment actions
- Messages inbox + send message to profile owner
- Related tracks sidebar
- Mini-player bar
- Dark glassmorphism UI

## Notes
- Waveforms are generated client-side with wavesurfer.js.
- Share buttons copy a track link to the clipboard.
- Upload MP3 files in `/uploads` or use the Upload page.
