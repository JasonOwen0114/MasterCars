# Railway Deployment: Persistent File Storage with S3

## Problem
Railway's filesystem is ephemeral — files written at runtime are lost on container restart or redeploy. This causes uploaded images to disappear from the database despite the file paths being saved.

## Solution
Use Amazon S3 (or S3-compatible) storage for persistent uploads.

---

## Setup Steps

### 1. Create an S3 Bucket

**Option A: AWS S3**
- Go to [AWS S3 Console](https://s3.console.aws.amazon.com/)
- Create a new bucket (e.g., `ta-inspeksi-uploads`)
- Enable public access if images need to be viewable in browser
- Create an IAM user with S3 permissions:
  - Go to IAM → Users → Create user
  - Attach policy: `AmazonS3FullAccess` or custom policy for your bucket
  - Generate Access Key ID and Secret Access Key

**Option B: DigitalOcean Spaces** (cheaper alternative)
- Create a Space in DigitalOcean (e.g., `ta-inspeksi`)
- Generate API key/secret
- Endpoint format: `https://[space-name].[region].digitaloceanspaces.com`

### 2. Set Environment Variables on Railway

Add these to your Railway project environment:

```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_access_key_here
AWS_SECRET_ACCESS_KEY=your_secret_key_here
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=ta-inspeksi-uploads
AWS_URL=https://ta-inspeksi-uploads.s3.amazonaws.com
```

**For DigitalOcean Spaces:**
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_spaces_key
AWS_SECRET_ACCESS_KEY=your_spaces_secret
AWS_DEFAULT_REGION=nyc3
AWS_BUCKET=ta-inspeksi
AWS_ENDPOINT=https://nyc3.digitaloceanspaces.com
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_URL=https://ta-inspeksi.nyc3.digitaloceanspaces.com
```

### 3. Deploy to Railway

Push your changes:
```bash
git add config/filesystems.php .env.example
git commit -m "Configure S3 for persistent file storage on Railway"
git push
```

Railway will automatically redeploy.

### 4. Verify It Works

1. Upload a new image via the inspection form
2. Check your S3 bucket — the file should appear in `mobil/`, `eksterior/`, `interior/`, `mesin/`, or `kelengkapan/` folder
3. Refresh the page — the image should display from S3 URL
4. Restart the Railway container — image should still be visible

---

## How It Works

- `config/filesystems.php` now checks `FILESYSTEM_DISK=s3`
- When `s3`, all uploads to the `public` disk are stored in S3
- `asset('storage/mobil/...')` URLs are rewritten to S3 URLs automatically
- No code changes needed in `StaffController` — it already uses the `public` disk

---

## Troubleshooting

**Images still not visible?**
- Verify `AWS_ACCESS_KEY_ID` and `AWS_SECRET_ACCESS_KEY` are correct
- Check bucket name matches exactly
- Ensure bucket policy allows public read access
- Check application logs: `railway logs`

**S3 bucket not accessible?**
- Verify IAM user has `s3:*` or `s3:GetObject`, `s3:PutObject` permissions
- Check endpoint is correct for your region

**Local development broken?**
- Keep `FILESYSTEM_DISK=local` in local `.env` (default)
- Files upload to `storage/app/public` locally
- Only set `FILESYSTEM_DISK=s3` on Railway

---

## Migrating Existing Uploads

If you have existing images in the database but they're missing:
1. They can't be recovered from the ephemeral filesystem
2. Upload them again via the inspection form
3. Database paths will be updated automatically

---

## Costs

- AWS S3: ~$0.023/GB/month for storage, request fees
- DigitalOcean Spaces: $5/month for 250GB (flat rate)
