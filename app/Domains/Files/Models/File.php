<?php

namespace App\Domains\Files\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class File extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $fillable = ['title', 'filename', 'description', 'type'];

    protected $appends = ['src','format'];

    public function getSrcAttribute(): string
    {
        return $this->type == 'public' ? '/storage/uploads/' . $this->filename : '/admin/files/stream?id=' . $this->id;
    }

    public function getFormatAttribute()
    {
        $format = explode('.', $this->filename);
        $format = strtoupper(end($format));
        switch ($format) {
            case 'PNG':
            case 'JPEG':
            case 'JPG':
                return 'image';
                break;
            case 'PDF':
                return 'pdf';
                break;
            case 'MP4':
                return 'video';
                break;
            case 'MP3':
                return 'audio';
                break;
            default:
                return 'Unknown';
        }
    }
}
