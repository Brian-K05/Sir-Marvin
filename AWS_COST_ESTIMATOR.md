# AWS Cost Estimator for Sir Marvin Application

## Monthly Cost Breakdown

### Option 1: AWS Lightsail (RECOMMENDED) ⭐

| Service | Specification | Monthly Cost |
|---------|--------------|--------------|
| **Lightsail Instance** | 1 GB RAM, 1 vCPU, 40 GB SSD | $5.00 |
| **Lightsail Database** | MySQL 8.0, 1 GB RAM, 20 GB SSD | $15.00 |
| **Static IP** | Attached to instance | $0.00 |
| **SSL Certificate** | Free SSL/TLS | $0.00 |
| **Data Transfer** | First 1 TB included | $0.00 |
| **Snapshots** | Optional backups | $0.00-2.00 |
| **TOTAL** | | **$20.00/month** |

**Best for**: Small to medium traffic (100-1,000 daily visitors)

---

### Option 2: EC2 + RDS (More Control)

| Service | Specification | Monthly Cost |
|---------|--------------|--------------|
| **EC2 t3.micro** | 2 vCPU, 1 GB RAM | $7.50 |
| **EC2 t3.small** | 2 vCPU, 2 GB RAM | $15.00 |
| **RDS db.t4g.micro** | MySQL 8.0, 1 GB RAM | $12.00 |
| **EBS Storage** | 30 GB gp3 | $2.40 |
| **RDS Storage** | 20 GB gp3 | $1.60 |
| **Elastic IP** | Static IP | $0.00 |
| **Data Transfer** | First 100 GB free | $0.00-5.00 |
| **TOTAL (t3.micro)** | | **~$23.50/month** |
| **TOTAL (t3.small)** | | **~$31.00/month** |

**Best for**: Need more control, custom configurations

---

### Option 3: EC2 + RDS (Free Tier - First Year)

| Service | Specification | Monthly Cost |
|---------|--------------|--------------|
| **EC2 t2.micro** | 750 hours/month FREE | $0.00 |
| **RDS db.t2.micro** | 750 hours/month FREE | $0.00 |
| **EBS Storage** | 30 GB (first 30 GB free) | $0.00 |
| **RDS Storage** | 20 GB (first 20 GB free) | $0.00 |
| **Data Transfer** | First 100 GB free | $0.00 |
| **TOTAL** | | **$0.00/month** |

**Best for**: Testing, development, first year

---

## Traffic Capacity Estimates

### Lightsail 1 GB Instance:
- **Concurrent Users**: 20-50
- **Daily Visitors**: 500-1,000
- **Page Views/Day**: 2,000-5,000
- **Database Queries**: Handles moderate load

### When to Upgrade:

| Current Plan | Upgrade When | New Cost |
|-------------|--------------|----------|
| 1 GB RAM | >1,000 daily visitors | +$5/month (2 GB) |
| 2 GB RAM | >5,000 daily visitors | +$10/month (4 GB) |
| Database 1 GB | >10,000 records + heavy queries | +$15/month (2 GB) |

---

## Additional Costs (Optional)

### S3 for File Storage:
- **Storage**: $0.023/GB/month
- **Requests**: $0.005 per 1,000 requests
- **Data Transfer Out**: First 100 GB free
- **Estimated**: $1-3/month (for document storage)

### CloudFront CDN:
- **Free Tier**: 50 GB data transfer
- **After Free Tier**: $0.085/GB
- **Estimated**: $0-5/month (depending on traffic)

### Backup Costs:
- **Lightsail Snapshots**: $0.05/GB/month
- **RDS Snapshots**: $0.095/GB/month
- **Estimated**: $1-3/month (for weekly backups)

---

## Total Cost Scenarios

### Scenario 1: Minimal Setup (Lightsail)
- Lightsail Instance: $5
- Lightsail Database: $15
- **Total: $20/month**

### Scenario 2: With S3 Storage
- Lightsail Instance: $5
- Lightsail Database: $15
- S3 Storage: $2
- **Total: $22/month**

### Scenario 3: With CDN
- Lightsail Instance: $5
- Lightsail Database: $15
- CloudFront: $3
- **Total: $23/month**

### Scenario 4: Full Setup
- Lightsail Instance: $5
- Lightsail Database: $15
- S3 Storage: $2
- CloudFront: $3
- Backups: $2
- **Total: $27/month**

---

## Cost Savings Tips

### 1. Use Free Tier (First Year)
- Save $20-30/month
- Perfect for testing and initial launch

### 2. Choose Lightsail Over EC2
- Fixed pricing: $20/month
- No surprise charges
- Easier to budget

### 3. Use ARM-Based Instances
- db.t4g.micro is 20% cheaper than db.t3.micro
- Same performance

### 4. Optimize Storage
- Use S3 for large files (cheaper than EBS)
- Delete unused snapshots
- Compress backups

### 5. Monitor Usage
- Set up billing alerts
- Review monthly costs
- Optimize based on actual usage

### 6. Use Reserved Instances (Long-term)
- Save up to 72% with 3-year commitment
- Only if you're sure about long-term usage

---

## Comparison with Other Hosting

| Hosting Provider | Monthly Cost | Notes |
|-----------------|--------------|-------|
| **AWS Lightsail** | $20 | Recommended ⭐ |
| **DigitalOcean** | $12-24 | Similar to Lightsail |
| **Linode** | $12-24 | Good alternative |
| **Shared Hosting** | $5-15 | Limited, not recommended |
| **VPS (OVH, Hetzner)** | $5-10 | Europe-based, cheaper |
| **Heroku** | $25-50 | Easy but expensive |

---

## ROI Analysis

### Expected Revenue vs. Hosting Cost:

| Monthly Revenue | Hosting Cost | ROI |
|----------------|--------------|-----|
| $100 | $20 | 400% |
| $500 | $20 | 2,400% |
| $1,000 | $20 | 4,900% |

**Conclusion**: Even with minimal revenue, hosting cost is negligible.

---

## Recommended Setup for Your Application

### Phase 1: Launch (Months 1-12)
- **AWS Free Tier** or **Lightsail $20/month**
- Test and optimize
- Monitor traffic

### Phase 2: Growth (Months 13-24)
- **Lightsail 2 GB**: $10/month
- **Database 2 GB**: +$15/month
- **Total: $30/month**

### Phase 3: Scale (Months 25+)
- **EC2 + RDS** or **Elastic Beanstalk**
- Auto-scaling enabled
- **Total: $50-100/month**

---

## Final Recommendation

**Start with AWS Lightsail at $20/month**

**Why?**
1. ✅ Lowest cost for full-featured hosting
2. ✅ Predictable pricing (no surprises)
3. ✅ Easy setup and management
4. ✅ Free SSL certificate
5. ✅ Can scale up anytime
6. ✅ Perfect for 100-1,000 daily visitors

**Upgrade path:**
- Month 1-12: Lightsail 1 GB ($20/month)
- Month 13+: Lightsail 2 GB ($25/month) if needed
- Year 2+: EC2 + RDS ($30-50/month) if traffic grows

This gives you the best balance of cost and performance! 🚀

