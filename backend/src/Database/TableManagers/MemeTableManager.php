<?php

namespace Database\TableManagers;

use Database\DatabaseQuery;
use Models\Meme;

class MemeTableManager extends TableManager
{

    //--------get methods----------------
    // general get method
    /**
     * Get memes from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return Meme[]
     */
    static public function getMeme(array $params = []): array
    {
        $queryObjects =  DatabaseQuery::executeQuery("select", "memes", [], $params, " id NOT IN (SELECT meme_id FROM blocked_memes)");
        $memes = [];
        foreach ($queryObjects as $queryObject) {
            $memes[] = new Meme(
                $queryObject['id'],
                $queryObject['template_id'],
                $queryObject['custom_title'],
                $queryObject['user_id'],
                $queryObject['creation_date'],
                $queryObject['result_img'],
                $queryObject['nb_likes']
            );
        }
        return $memes;
    }

    /**
     * Retrieves all memes from the database.
     *
     *
     * @param array $params An associative array of parameters to be used in the SQL query. Default is an empty array.
     * @return array An array of Meme objects.
     */
    static public function getAllMemes(array $params = []): array
    {
        $queryObjects =  DatabaseQuery::executeQuery("select", "memes", [], $params);
        $memes = [];
        foreach ($queryObjects as $queryObject) {
            $memes[] = new Meme(
                $queryObject['id'],
                $queryObject['template_id'],
                $queryObject['custom_title'],
                $queryObject['user_id'],
                $queryObject['creation_date'],
                $queryObject['result_img'],
                $queryObject['nb_likes']
            );
        }
        return $memes;
    }

    // specific get methods
    /**
     * Retrieves a meme from the database by its ID.
     *
     *
     * @param int $id The ID of the meme to retrieve.
     * @param bool $blocked Whether to include blocked memes. Default is false.
     * @return Meme|null The Meme object if found, null otherwise.
     */
    static public function getMemeById(int $id, bool $blocked = false): ?Meme
    {
        if ($id < 0) {
            return null;
        }
        if ($blocked) {
            $memes = self::getAllMemes(["id" => $id]);
        } else {
            $memes = self::getMeme(["id" => $id]);
        }
        if (!empty($memes)) {
            return $memes[0];
        }
        return null;
    }

    /**
     * Retrieves memes from the database by their template ID.
     *
     *
     * @param int $template_id The ID of the template to retrieve memes for.
     * @return array|null An array of Meme objects if found, null otherwise.
     */
    static public function getMemeByTemplateId(int $template_id): ?array
    {
        if (!TemplateTableManager::templateExists($template_id)) {
            return null;
        }
        return self::getMeme(["template_id" => $template_id]);
    }

    /**
     * Retrieves memes from the database by their user ID.
     *
     *
     * @param int $user_id The ID of the user to retrieve memes for.
     * @return array|null An array of Meme objects if found, null otherwise.
     */
    static public function getMemeByUserId(int $user_id): ?array
    {
        if (!UserTableManager::verifyExistenceById($user_id)) {
            return null;
        }
        return self::getMeme(["user_id" => $user_id]);
    }

    /**
     * Retrieves memes from the database by their creation date.
     *
     *
     * @param string $creation_date The creation date to retrieve memes for, in the format "YYYY-MM-DD HH:MM:SS".
     * @return array|null An array of Meme objects if found, null otherwise.
     */
    static public function getMemeByCreationDate(string $creation_date): ?array
    {
        if (empty($creation_date) || !preg_match("/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/", $creation_date)) {
            return null;
        }
        return self::getMeme(["creation_date" => $creation_date]);
    }

    /**
     * Retrieves memes from the database by their custom title.
     *
     *
     * @param string $custom_title The custom title to retrieve memes for.
     * @return array|null An array of Meme objects if found, null otherwise.
     */
    static public function getMemeByCustomTitle(string $custom_title): ?array
    {
        if (empty($custom_title)) {
            return null;
        }
        return self::getMeme(["custom_title" => $custom_title]);
    }

    /**
     * Retrieves memes from the database by their number of likes.
     *
     *
     * @param int $nb_likes The number of likes to retrieve memes for.
     * @return array|null An array of Meme objects if found, null otherwise.
     */
    static public function getMemeByNbLikes(int $nb_likes): ?array
    {
        if ($nb_likes < 0) {
            return null;
        }
        return self::getMeme(["nb_likes" => $nb_likes]);
    }

    static public function getMemeNbLikes(int $meme_id): int
    {
        $meme = self::getMemeById($meme_id);
        if ($meme) {
            return $meme->getNbLikes();
        }
        return 0;
    }

    //--------verify existence methods----------------
    /**
     * Checks if a meme exists in the database by its ID.
     *
     * @param int $id The ID of the meme to check.
     * @param bool $blocked Whether to include blocked memes. Default is false.
     * @return bool True if the meme exists, false otherwise.
     */
    static public function memeExists(int $id, bool $blocked = false): bool
    {
        return !empty(self::getMemeById($id, $blocked));
    }

    /**
     * Checks if a meme exists in the database by its template ID.
     *
     *
     * @param int $template_id The ID of the template to check.
     * @return bool True if the meme exists, false otherwise.
     */
    static public function memeExistsByTemplateId(int $template_id): bool
    {
        return !empty(self::getMemeByTemplateId($template_id));
    }

    /**
     * Checks if a meme exists in the database by its user ID.
     *
     *
     * @param int $user_id The ID of the user to check.
     * @return bool True if the meme exists, false otherwise.
     */
    static public function memeExistsByUserId(int $user_id): bool
    {
        return !empty(self::getMemeByUserId($user_id));
    }

    /**
     * Checks if a meme exists in the database by its custom title.
     *
     *
     * @param string $custom_title The custom title to check.
     * @return bool True if the meme exists, false otherwise.
     */
    static public function memeExistsByCustomTitle(string $custom_title): bool
    {
        return !empty(self::getMemeByCustomTitle($custom_title));
    }


    //--------add method----------------
    /**
     * Add meme to database based on template_id, custom_title and user_id given as parameters and return the meme object
     * @param int $template_id
     * @param string $custom_title
     * @param int $user_id
     * @param string $result_img
     * @return Meme|null
     */
    static public function addMeme(int $template_id, string $custom_title, int $user_id, string $result_img): ?Meme
    {
        if (!UserTableManager::verifyExistenceById($user_id) || !TemplateTableManager::templateExists($template_id)) {
            return null;
        }
        DatabaseQuery::executeQuery("insert", "memes", ["template_id" => $template_id, "custom_title" => $custom_title, "user_id" => $user_id, "result_img" => $result_img]);
        $id = DatabaseQuery::getLastInsertId();
        return self::getMemeById($id);
    }

    //--------update methods----------------
    // general update method
    /**
     * Update meme in database based on id and attributes given as parameters and return the meme object
     * @param int $id
     * @param array $attributes
     * @return Meme|null
     */
    static public function updateMeme(int $id, array $attributes): ?Meme
    {
        if (!self::memeExists($id)) {
            return null;
        }
        DatabaseQuery::executeQuery("update", "memes", $attributes, ["id" => $id]);
        return self::getMemeById($id);
    }

    // specific update methods
    /**
     * Updates the template ID of a meme in the database.
     *
     *
     * @param int $id The ID of the meme to update.
     * @param int $template_id The new template ID for the meme.
     * @return Meme|null The updated Meme object if successful, null otherwise.
     */
    static public function updateMemeTemplateId(int $id, int $template_id): ?Meme
    {
        if (!TemplateTableManager::templateExists($template_id) || !self::memeExists($id)) {
            return null;
        }
        return self::updateMeme($id, ["template_id" => $template_id]);
    }

    /**
     * Updates the custom title of a meme in the database.
     *
     *
     * @param int $id The ID of the meme to update.
     * @param string $custom_title The new custom title for the meme.
     * @return Meme|null The updated Meme object if successful, null otherwise.
     */
    static public function updateMemeCustomTitle(int $id, string $custom_title): ?Meme
    {
        if (empty($custom_title) || !self::memeExists($id)) {
            return null;
        }
        return self::updateMeme($id, ["custom_title" => $custom_title]);
    }

    /**
     * Updates the user ID of a meme in the database.
     *
     * @param int $id The ID of the meme to update.
     * @param int $user_id The new user ID for the meme.
     * @return Meme|null The updated Meme object if successful, null otherwise.
     */
    static public function updateMemeUserId(int $id, int $user_id): ?Meme
    {
        if (!UserTableManager::verifyExistenceById($user_id) || !self::memeExists($id)) {
            return null;
        }
        return self::updateMeme($id, ["user_id" => $user_id]);
    }

    /**
     * Updates the result image of a meme in the database.
     *
     *
     * @param int $id The ID of the meme to update.
     * @param string $result_img The new result image for the meme.
     * @return Meme|null The updated Meme object if successful, null otherwise.
     */
    static public function updateMemeResultImg(int $id, string $result_img): ?Meme
    {
        if (empty($result_img) || !self::memeExists($id)) {
            return null;
        }
        return self::updateMeme($id, ["result_img" => $result_img]);
    }

    //--------delete method----------------
    /**
     * Delete meme from database based on id given as parameter
     * @param int $id
     */
    static public function deleteMeme(int $id): void
    {
        if (!self::memeExists($id)) {
            return;
        }
        DatabaseQuery::executeQuery("delete", "memes", [], ["id" => $id]);
    }

    //--------retrieve method----------------


    /**
     * Retrieves a Meme model from the database.
     *
     *
     * @param int $id The ID of the meme to retrieve.
     * @return Meme|null The Meme model if found, null otherwise.
     */
    public static function retrieve($id): ?Meme
    {
        return self::getMemeById($id, true);
    }

    //--------sort methods----------------

    /**
     * Sort an array of memes by their creation date in ascending order
     * @param array $memes
     * @return array
     */
    static public function sortMemesByDate(array $memes): array
    {
        usort($memes, function ($a, $b) {
            return strtotime($a->getCreationDate()) - strtotime($b->getCreationDate());
        });
        return $memes;
    }
}
