<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="studentId", referencedColumnName="id")
     */
    private $student;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="advisorId", referencedColumnName="id")
     */
    private $advisor;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=500)
     *
     * Sim, eu sei que poderia ser $title.
     * Mas eu não quis mudar.
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(name="article", type="string", length=255, nullable=true)
     * @Assert\File(
     *     mimeTypes={"application/pdf"},
     *     maxSize = "209715200",
     *     mimeTypesMessage = "Artigo muito grande."
     *     )
     */
    private $article;

    /**
     * @var string|null
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     * @Assert\File(
     *     mimeTypes={"application/zip", "application/rar", "application/x-rar"},
     *     maxSize = "209715200",
     *     mimeTypesMessage = "Codigo muito grande."
     *     )
     */
    private $code;

    /**
     * @ORM\OneToOne(targetEntity="Board")
     * @ORM\JoinColumn(name="boardId", referencedColumnName="id", onDelete="CASCADE")
     */
    private $board;

    /**
     * @ORM\Column(name="firstPost", type="boolean")
     */
    private $firstPost = false;

    /**
     * @ORM\Column(name="firstPostDate", type="datetime")
     */
    private $firstPostDate;

    /**
     * @ORM\Column(name="lastPost", type="boolean")
     */
    private $lastPost = false;

    /**
     * @ORM\Column(name="lastPostDate", type="datetime")
     */
    private $lastPostDate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param mixed $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    public function getAdvisor()
    {
        return $this->advisor;
    }

    /**
     * @param mixed $advisor
     */
    public function setAdvisor($advisor)
    {
        $this->advisor = $advisor;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return null|string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param null|string $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @return null|string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param null|string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param mixed $board
     */
    public function setBoard($board)
    {
        $this->board = $board;
    }

    /**
     * @return mixed
     */
    public function getFirstPostDate()
    {
        return $this->firstPostDate;
    }

    /**
     * @param mixed $firstPostDate
     */
    public function setFirstPostDate($firstPostDate)
    {
        $this->firstPostDate = $firstPostDate;
    }

    /**
     * @return mixed
     */
    public function getLastPostDate()
    {
        return $this->lastPostDate;
    }

    /**
     * @param mixed $lastPostDate
     */
    public function setLastPostDate($lastPostDate)
    {
        $this->lastPostDate = $lastPostDate;
    }

    /**
     * @return mixed
     */
    public function getFirstPost()
    {
        return $this->firstPost;
    }

    /**
     * @param mixed $firstPost
     */
    public function setFirstPost($firstPost)
    {
        $this->firstPost = $firstPost;
    }

    /**
     * @return mixed
     */
    public function getLastPost()
    {
        return $this->lastPost;
    }

    /**
     * @param mixed $lastPost
     */
    public function setLastPost($lastPost)
    {
        $this->lastPost = $lastPost;
    }

    public function __toString()
    {
        return $this->getName();
    }

}
