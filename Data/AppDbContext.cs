using KhonokRank.Models;
using Microsoft.EntityFrameworkCore;

namespace KhonokRank.Data;

public class AppDbContext : DbContext
{
    public AppDbContext(DbContextOptions<AppDbContext> options) : base(options)
    {
    }

    public DbSet<Teacher> Teachers { get; set; }
}
