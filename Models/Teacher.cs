using System.ComponentModel.DataAnnotations;

namespace KhonokRank.Models;

public class Teacher
{
    public int Id { get; set; }

    [Required]
    public string Name { get; set; }

    public string? Description { get; set; }

    [Required]
    public float Rank { get; set; }
}
